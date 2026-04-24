from fastapi import APIRouter, Depends, HTTPException, Body
from sqlalchemy.orm import Session
from backend.db.database import get_db
from backend.db import models, crud
from backend.schemas import scan_schema
from backend.services import scan_service
import uuid

router = APIRouter()

@router.post("/scan", response_model=scan_schema.ScanResponse)
async def start_scan(
    payload: scan_schema.ScanCreate,
    db: Session = Depends(get_db)
):
    """
    Initializes a new scan request.
    """
    # 1. Target Validation
    if not scan_service.is_valid_target(payload.target):
        raise HTTPException(status_code=400, detail="Invalid target or restricted IP")
        
    # 2. Check Concurrent Scans
    if scan_service.get_active_scans_count(db) >= 3:
        raise HTTPException(status_code=429, detail="Maximum concurrent scans reached")
        
    # 3. Create Scan Record
    scan_id = str(uuid.uuid4())
    new_scan = models.Scan(
        id=scan_id,
        target=payload.target,
        mode=payload.mode,
        status="PENDING",
        user_id=1 # Default user for now
    )
    db.add(new_scan)
    db.commit()
    
    # 4. Trigger Celery Task
    scan_service.enqueue_scan(scan_id, payload.target, payload.mode)
    
    return new_scan

@router.get("/scan/{scan_id}", response_model=scan_schema.ScanDetail)
def get_scan_status(scan_id: str, db: Session = Depends(get_db)):
    scan = db.query(models.Scan).filter(models.Scan.id == scan_id).first()
    if not scan:
        raise HTTPException(status_code=404, detail="Scan not found")
    return scan

@router.get("/reports")
def list_reports(db: Session = Depends(get_db), limit: int = 10, offset: int = 0):
    return db.query(models.Scan).order_by(models.Scan.last_scan_at.desc()).offset(offset).limit(limit).all()
