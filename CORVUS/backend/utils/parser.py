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
                results.append({
                    "type": data.get("template-id"),
                    "severity": data.get("info", {}).get("severity", "info").upper(),
                    "source": "nuclei",
                    "endpoint": data.get("matched-at"),
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
        """Parses dalfox findings."""
        # Dalfox output parsing logic
        results = []
        # Implementation depends on dalfox output format (JSON/Text)
        return results
