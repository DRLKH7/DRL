import json
import logging
import re
from typing import List, Dict, Any

logger = logging.getLogger("corvus.parser")

class Parser:
    @staticmethod
    def parse_nuclei(output: str) -> List[Dict[str, Any]]:
        """Parses Nuclei JSON output lines."""
        results = []
        for line in output.strip().split('\n'):
            if not line: continue
            try:
                data = json.loads(line)
                # Ensure endpoint is extracted from matched-at or template-id
                endpoint = data.get("matched-at") or data.get("url", "/")
                results.append({
                    "type": data.get("template-id"),
                    "severity": data.get("info", {}).get("severity", "info").lower(),
                    "source": "nuclei",
                    "endpoint": endpoint,
                    "raw": data,
                    "confidence": 1.0
                })
            except json.JSONDecodeError:
                continue
        return results

    @staticmethod
    def parse_subfinder(output: str) -> List[str]:
        """Parses subfinder output (list of domains)."""
        return [line.strip() for line in output.strip().split('\n') if line.strip()]

    @staticmethod
    def parse_httpx(output: str) -> List[Dict[str, str]]:
        """Parses httpx JSON output."""
        results = []
        for line in output.strip().split('\n'):
            if not line: continue
            try:
                data = json.loads(line)
                results.append({
                    "url": data.get("url"),
                    "title": data.get("title"),
                    "status_code": data.get("status_code"),
                    "host": data.get("host")
                })
            except json.JSONDecodeError:
                continue
        return results
    
    @staticmethod
    def parse_dalfox(output: str) -> List[Dict[str, Any]]:
        """Parses Dalfox output (expecting JSON per line or simple text)."""
        results = []
        for line in output.strip().split('\n'):
            if not line: continue
            if '"type":"vulnerability"' in line: # Dalfox JSON format
                try:
                    data = json.loads(line)
                    results.append({
                        "type": "xss",
                        "severity": "high",
                        "source": "dalfox",
                        "endpoint": data.get("url"),
                        "raw": data,
                        "confidence": 1.0
                    })
                except: continue
            elif "[POC]" in line: # Dalfox text format
                parts = line.split(" ")
                url = parts[-1] if parts else "unknown"
                results.append({
                    "type": "xss",
                    "severity": "high",
                    "source": "dalfox",
                    "endpoint": url,
                    "raw": line,
                    "confidence": 0.9
                })
        return results

    @staticmethod
    def parse_ffuf(output: str) -> List[Dict[str, Any]]:
        """Parses ffuf JSON output."""
        results = []
        try:
            data = json.loads(output)
            for result in data.get("results", []):
                results.append({
                    "type": "directory_discovery",
                    "severity": "info",
                    "source": "ffuf",
                    "endpoint": result.get("url"),
                    "status_code": result.get("status"),
                    "length": result.get("length"),
                    "raw": result,
                    "confidence": 1.0
                })
        except:
            # Fallback for line-delimited JSON
            for line in output.strip().split('\n'):
                try:
                    data = json.loads(line)
                    results.append({
                        "type": "directory_discovery",
                        "severity": "info",
                        "source": "ffuf",
                        "endpoint": data.get("url"),
                        "status_code": data.get("status"),
                        "raw": data,
                        "confidence": 1.0
                    })
                except: continue
        return results

    @staticmethod
    def parse_katana(output: str) -> List[str]:
        """Parses katana output (list of URLs)."""
        return [line.strip() for line in output.strip().split('\n') if line.strip()]

    @staticmethod
    def parse_naabu(output: str) -> List[Dict[str, Any]]:
        """Parses naabu output (ip:port)."""
        results = []
        for line in output.strip().split('\n'):
            if ":" in line:
                host, port = line.split(":")
                results.append({"host": host, "port": port})
        return results

    @staticmethod
    def parse_list(output: str) -> List[str]:
        """Generic parser for tool output that returns a list of strings (gau, subfinder, assetfinder)."""
        return [line.strip() for line in output.strip().split('\n') if line.strip()]

    @staticmethod
    def parse_loxs(output: str) -> List[Dict[str, Any]]:
        """Parses LOXS scanner output."""
        results = []
        # LOXS usually outputs findings with [!] or [+]
        patterns = {
            "xss": r"XSS.*FOUND",
            "sqli": r"SQLi.*FOUND",
            "lfi": r"LFI.*FOUND"
        }
        for line in output.strip().split('\n'):
            for vuln_type, pattern in patterns.items():
                if re.search(pattern, line, re.IGNORECASE):
                    # Try to extract URL
                    url_match = re.search(r'http[s]?://[^\s]+', line)
                    url = url_match.group(0) if url_match else "unknown"
                    results.append({
                        "type": vuln_type,
                        "severity": "high",
                        "source": "loxs",
                        "endpoint": url,
                        "raw": line,
                        "confidence": 0.8
                    })
        return results
