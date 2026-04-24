# backend/core/owasp.py
def map_to_owasp(vuln_type: str) -> str:
    """Matches vulnerability types to OWASP Top 10 categories."""
    mapping = {
        "xss": "A03:2021-Injection",
        "sql_injection": "A03:2021-Injection",
        "broken_auth": "A01:2021-Broken Access Control",
        "sensitive_data": "A04:2021-Insecure Design",
        "misconfiguration": "A05:2021-Security Misconfiguration"
    }
    return mapping.get(vuln_type.lower(), "A00:2021-Unknown")
