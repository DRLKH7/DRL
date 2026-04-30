import requests
import time
import socket
from typing import List, Dict, Any
from backend.config import settings

def check_security_headers(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        response = requests.head(url, timeout=10, allow_redirects=True)
        headers = response.headers
        missing = []
        for header in ["Strict-Transport-Security", "Content-Security-Policy", "X-Frame-Options", "X-Content-Type-Options", "Referrer-Policy", "Permissions-Policy"]:
            if header not in headers:
                missing.append(header)
        
        if missing:
            findings.append({
                "type": "missing_security_headers",
                "name": "Missing Security Headers",
                "severity": "LOW",
                "location": url,
                "description": f"Missing headers: {', '.join(missing)}",
                "remediation": "Implement recommended security headers (HSTS, CSP, X-Frame-Options, etc.)."
            })
    except Exception:
        pass
    return findings

def check_clickjacking(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        response = requests.get(url, timeout=10)
        headers = response.headers
        xfo = headers.get("X-Frame-Options", "").upper()
        csp = headers.get("Content-Security-Policy", "")
        
        if "DENY" not in xfo and "SAMEORIGIN" not in xfo and "frame-ancestors" not in csp:
            findings.append({
                "type": "clickjacking",
                "name": "Clickjacking Vulnerability",
                "severity": "MEDIUM",
                "location": url,
                "description": "The page does not use X-Frame-Options or CSP frame-ancestors to prevent framing.",
                "remediation": "Add 'X-Frame-Options: SAMEORIGIN' or CSP 'frame-ancestors' directive."
            })
    except Exception:
        pass
    return findings

def check_cors_misconfig(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        headers = {'Origin': 'https://evil.com'}
        response = requests.options(url, headers=headers, timeout=10)
        acoa = response.headers.get("Access-Control-Allow-Origin")
        
        if acoa == "*" or acoa == "https://evil.com":
             findings.append({
                "type": "cors_misconfiguration",
                "name": "CORS Misconfiguration",
                "severity": "MEDIUM",
                "location": url,
                "description": f"Allowed Origin: {acoa}. This allows malicious sites to read data from this endpoint.",
                "remediation": "Restrict Access-Control-Allow-Origin to trusted domains."
            })
    except Exception:
        pass
    return findings

def check_rate_limiting(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        max_req = settings.SAFE_RATE_LIMIT_REQUESTS
        success_count = 0
        for _ in range(max_req):
            resp = requests.get(url, timeout=5)
            if resp.status_code != 429:
                success_count += 1
            time.sleep(0.2)
            
        if success_count == max_req:
             findings.append({
                "type": "no_rate_limiting",
                "name": "No Rate Limiting Detected",
                "severity": "LOW",
                "location": url,
                "description": f"Target did not return 429 Too Many Requests after {max_req} rapid requests.",
                "remediation": "Implement rate limiting/throttling to prevent brute force and DoS."
            })
    except Exception:
        pass
    return findings

def check_information_disclosure(url: str) -> List[Dict[str, Any]]:
    findings = []
    base_url = url.rsplit("/", 1)[0] if "/" in url.replace("://", "") else url
    paths = ["/.git/HEAD", "/robots.txt", "/server-status", "/phpinfo.php", "/.env"]
    for path in paths:
        try:
            target = f"{base_url.rstrip('/')}{path}"
            resp = requests.head(target, timeout=5)
            if resp.status_code == 200:
                findings.append({
                    "type": "information_disclosure",
                    "name": "Potential Information Disclosure",
                    "severity": "MEDIUM" if path != "/robots.txt" else "INFO",
                    "location": target,
                    "description": f"Sensitive path exposed: {path}",
                    "remediation": f"Restrict access to {path} or remove it if not needed."
                })
        except Exception:
            continue
    return findings

def check_exposed_admin_panels(url: str) -> List[Dict[str, Any]]:
    findings = []
    base_url = url.rsplit("/", 1)[0] if "/" in url.replace("://", "") else url
    paths = ["/admin", "/wp-admin", "/phpmyadmin", "/dashboard", "/login"]
    for path in paths:
        try:
            target = f"{base_url.rstrip('/')}{path}"
            resp = requests.head(target, timeout=5)
            if resp.status_code == 200:
                findings.append({
                    "type": "exposed_admin_panel",
                    "name": "Exposed Admin Panel",
                    "severity": "MEDIUM",
                    "location": target,
                    "description": f"Administration panel discovered at {path}.",
                    "remediation": "Restrict admin access to specific IP ranges or hidden paths."
                })
        except Exception:
            continue
    return findings

def check_http_methods(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        resp = requests.options(url, timeout=10)
        allow = resp.headers.get("Allow", "").upper()
        dangerous = [m for m in ["PUT", "DELETE", "TRACK", "TRACE"] if m in allow]
        if dangerous:
            findings.append({
                "type": "dangerous_http_methods",
                "name": "Dangerous HTTP Methods Enabled",
                "severity": "LOW",
                "location": url,
                "description": f"Allowed methods: {allow}. Dangerous: {', '.join(dangerous)}",
                "remediation": "Disable non-essential HTTP methods like PUT, DELETE, and TRACE."
            })
    except Exception:
        pass
    return findings

def check_cookie_security(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        resp = requests.get(url, timeout=10)
        for cookie in resp.cookies:
            missing = []
            if not cookie.secure: missing.append("Secure")
            if not getattr(cookie, 'HttpOnly', True): missing.append("HttpOnly") # requests cookiejar handles this differently
            
            # Re-checking raw header for better accuracy on HttpOnly
            raw_cookies = resp.headers.get("Set-Cookie", "")
            if cookie.name in raw_cookies:
                if "HttpOnly" not in raw_cookies: 
                    if "HttpOnly" not in missing: missing.append("HttpOnly")
            
            if missing:
                findings.append({
                    "type": "cookie_security",
                    "name": "Insecure Cookie Attributes",
                    "severity": "LOW",
                    "location": url,
                    "description": f"Cookie '{cookie.name}' is missing: {', '.join(missing)}",
                    "remediation": "Set Secure and HttpOnly flags on all sensitive cookies."
                })
    except Exception:
        pass
    return findings

def detect_xxe_potential(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        resp = requests.get(url, timeout=10)
        content = resp.text.lower()
        if 'type="file"' in content or '<form' in content:
            # Check for XML content type acceptance
             findings.append({
                "type": "xxe_potential",
                "name": "Potential XXE Vulnerability",
                "severity": "INFO",
                "location": url,
                "description": "Target accepts file uploads or has forms; could be vulnerable to XXE if XML parsing is enabled.",
                "remediation": "Disable DTD processing in XML parsers. Manual verification required."
            })
    except Exception:
        pass
    return findings

def detect_ssrf_potential(url: str) -> List[Dict[str, Any]]:
    findings = []
    try:
        # Check URL parameters for potential SSRF targets
        if "?" in url:
             findings.append({
                "type": "ssrf_potential",
                "name": "Potential SSRF Vulnerability",
                "severity": "INFO",
                "location": url,
                "description": "URL contains parameters that might be used for internal requests (SSRF potential).",
                "remediation": "Validate all URL parameters against a whitelist. Manual verification required."
            })
    except Exception:
        pass
    return findings

def check_dos_potential(url: str) -> List[Dict[str, Any]]:
    # Logically similar to rate limiting for this scope
    findings = []
    rl_findings = check_rate_limiting(url)
    if rl_findings:
        findings.append({
                "type": "dos_potential",
                "name": "Potential Denial of Service (DoS)",
                "severity": "LOW",
                "location": url,
                "description": "No rate limiting detected; target might be susceptible to application-layer DoS.",
                "remediation": "Implement robust rate limiting and resource quotas."
            })
    return findings
