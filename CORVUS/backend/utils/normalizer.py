import hashlib
from typing import List, Dict, Any
from sqlalchemy.orm import Session
from backend.db import models

class Normalizer:
    @staticmethod
    def normalize_severity(severity: str) -> str:
        from backend.core.owasp import OWASP_SEVERITY_MAP
        s = severity.lower().strip()
        return OWASP_SEVERITY_MAP.get(s, "Informational")

    @staticmethod
    def generate_finding_hash(finding: Dict[str, Any]) -> str:
        """Generates a hash to identify duplicate findings."""
        # Significant fields: endpoint, type, source/parameter
        endpoint = finding.get("endpoint") or finding.get("location", "")
        vuln_type = finding.get("type") or finding.get("name", "")
        param = finding.get("parameter") or ""
        data = f"{endpoint}|{vuln_type}|{param}"
        return hashlib.sha256(data.encode()).hexdigest()

    @staticmethod
    def deduplicate(findings: List[Dict[str, Any]], db: Session = None, scan_id: str = None) -> List[Dict[str, Any]]:
        unique_findings = {}
        for f in findings:
            f_hash = Normalizer.generate_finding_hash(f)
            if f_hash not in unique_findings:
                f["severity"] = Normalizer.normalize_severity(f.get("severity", "INFO"))
                
                # Cross-scan deduplication logic
                if db and scan_id:
                    fingerprint = db.query(models.VulnerabilityFingerprint).filter(
                        models.VulnerabilityFingerprint.fingerprint == f_hash
                    ).first()
                    
                    if fingerprint:
                        if fingerprint.last_seen_scan_id != scan_id:
                            f["is_duplicate"] = True
                            f["original_scan_id"] = fingerprint.first_seen_scan_id
                            fingerprint.last_seen_scan_id = scan_id
                    else:
                        new_fp = models.VulnerabilityFingerprint(
                            fingerprint=f_hash,
                            first_seen_scan_id=scan_id,
                            last_seen_scan_id=scan_id
                        )
                        db.add(new_fp)
                        f["is_duplicate"] = False
                
                unique_findings[f_hash] = f
        
        if db:
            db.commit()
            
        return list(unique_findings.values())
