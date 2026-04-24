import hashlib
from typing import List, Dict, Any

class Normalizer:
    @staticmethod
    def normalize_severity(severity: str) -> str:
        s = severity.upper()
        if s in ["CRITICAL", "HIGH", "MEDIUM", "LOW", "INFO"]:
            return s
        if "HIGH" in s: return "HIGH"
        if "MEDIUM" in s: return "MEDIUM"
        if "LOW" in s: return "LOW"
        return "INFO"

    @staticmethod
    def generate_finding_hash(finding: Dict[str, Any]) -> str:
        """Generates a hash to identify duplicate findings."""
        # Significant fields: endpoint, type, source
        data = f"{finding.get('endpoint')}|{finding.get('type')}|{finding.get('source')}"
        return hashlib.md5(data.encode()).hexdigest()

    @staticmethod
    def deduplicate(findings: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        unique_findings = {}
        for f in findings:
            f_hash = Normalizer.generate_finding_hash(f)
            if f_hash not in unique_findings:
                f["severity"] = Normalizer.normalize_severity(f.get("severity", "INFO"))
                unique_findings[f_hash] = f
        return list(unique_findings.values())
