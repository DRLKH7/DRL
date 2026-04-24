from .celery_app import celery_app
from backend.core.orchestrator import Orchestrator
from backend.db.database import SessionLocal
from backend.db import models
import asyncio
import logging

logger = logging.getLogger("corvus.tasks")

@celery_app.task(bind=True, name="run_orchestrator_task")
def run_orchestrator_task(self, scan_id: str, target: str, mode: str):
    """
    Celery task that runs the Orchestrator.
    """
    db = SessionLocal()
    try:
        # Update status to RUNNING
        scan = db.query(models.Scan).filter(models.Scan.id == scan_id).first()
        if not scan: return
        scan.status = "RUNNING"
        db.commit()

        # Progress callback for WebSocket (simplified for task)
        async def progress_callback(percentage: int, message: str):
            # Update DB
            db_inner = SessionLocal()
            s = db_inner.query(models.Scan).filter(models.Scan.id == scan_id).first()
            if s:
                s.progress = percentage
                db_inner.commit()
            db_inner.close()
            # Here we would also push to Redis for WebSocket bridge

        # Run Orchestrator
        orchestrator = Orchestrator(scan_id, target, mode, progress_callback)
        findings = asyncio.run(orchestrator.run_scan())

        # Save findings
        for f in findings:
            db_find = SessionLocal()
            vuln = models.Vulnerability(
                scan_id=scan_id,
                type=f["type"],
                severity=f["severity"],
                source=f["source"],
                endpoint=f["endpoint"],
                raw_data=f.get("raw"),
                normalized_data=f,
                confidence=f.get("confidence", 0.5),
                owasp_category=f.get("owasp_category"),
                risk_score=f.get("risk_score")
            )
            db_find.add(vuln)
            db_find.commit()
            db_find.close()

        scan.status = "COMPLETED"
        scan.progress = 100
        db.commit()

    except Exception as e:
        logger.error(f"Task failed for scan {scan_id}: {str(e)}")
        if scan:
            scan.status = "FAILED"
            db.commit()
    finally:
        db.close()
