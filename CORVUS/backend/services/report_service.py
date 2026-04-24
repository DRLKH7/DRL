# backend/services/report_service.py
import json
from backend.db import models

class ReportService:
    @staticmethod
    def generate_json(scan: models.Scan) -> str:
        """Generates JSON report data."""
        report_data = {
            "id": scan.id,
            "target": scan.target,
            "status": scan.status,
            "findings": [
                {
                    "type": f.type,
                    "severity": f.severity,
                    "endpoint": f.endpoint,
                    "owasp": f.owasp_category,
                    "risk": f.risk_score
                } for f in scan.findings
            ]
        }
        return json.dumps(report_data, indent=2)

    @staticmethod
    def generate_pdf(scan_id: str):
        """Logic for PDF generation (requires pdfkit)"""
        pass
