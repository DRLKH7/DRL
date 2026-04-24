import logging
import asyncio
from typing import Dict, Any, List
from backend.utils.executor import Executor
from backend.errors import ToolError, ScanError
from backend.utils.validator import validate_target
from backend.utils.parser import Parser
from backend.utils.normalizer import Normalizer
from backend.core.jssecret import extract_secrets
from backend.core.owasp import map_to_owasp
from backend.core.ml import ml_risk_score
import os

logger = logging.getLogger("corvus.orchestrator")

class Orchestrator:
    def __init__(self, scan_id: str, target: str, mode: str, progress_callback=None):
        self.scan_id = scan_id
        self.target = target
        self.mode = mode
        self.progress_callback = progress_callback
        self.findings = []
        self.subdomains = []
        self.urls = []

    async def run_scan(self):
        """
        Main execution flow (Point #5):
        VALIDASI -> RECON -> DISCOVERY -> GF FILTER -> FUZZ -> VULN SCAN -> OWASP -> ML -> REPORT
        """
        try:
            # 0% - Validating Target
            await self._update_progress(5, "Validating target")
            self.target = validate_target(self.target)

            # 10% - Recon
            await self._update_progress(10, "Reconnaissance: Finding subdomains")
            await self._run_recon()

            # 30% - Discovery
            await self._update_progress(30, "Discovery: Collecting URLs and Assets")
            await self._run_discovery()

            # 40% - JS Secret Extraction
            await self._update_progress(40, "Analysis: Extracting secrets from JS files")
            await self._run_js_secret_extraction()

            # 60% - Scanning (Vuln & Fuzz)
            await self._update_progress(60, "Scanning: Running vulnerability checks")
            await self._run_vuln_scan()

            # 80% - Analysis & Scoring
            await self._update_progress(80, "Analysis: Risk scoring and mapping")
            await self._run_risk_analysis()

            # 100% - Done
            await self._update_progress(100, "Completed")
            return self.findings

        except Exception as e:
            logger.error(f"Scan {self.scan_id} failed: {str(e)}")
            await self._update_progress(0, f"Error: {str(e)}")
            raise

    async def _update_progress(self, percentage: int, message: str):
        if self.progress_callback:
            await self.progress_callback(percentage, message)

    def _validate_target(self) -> bool:
        # Check for private IPs, invalid domains, etc.
        # Implementation in validator.py
        return True

    async def _run_recon(self):
        """Runs subfinder, assetfinder etc."""
        try:
            # Placeholder for real subfinder call
            # output = Executor.run(["subfinder", "-d", self.target, "-silent"])
            # self.subdomains = Parser.parse_subfinder(output)
            self.subdomains = [self.target] # Default fall back
            logger.info(f"Recon found {len(self.subdomains)} subdomains")
        except ToolError:
            logger.warning("Recon tool failed, skipping...")

    async def _run_discovery(self):
        """Runs gau, katana etc."""
        # Mocking discovery
        self.urls = [f"https://{self.target}/js/app.js", f"https://{self.target}/api/v1"]

    async def _run_js_secret_extraction(self):
        """Extracts secrets from discovered JS files."""
        for url in self.urls:
            if url.endswith(".js"):
                try:
                    # Mocking fetching JS content
                    js_content = "const api_key = 'AIzaSyA_mock_key_1234567890';"
                    secrets = extract_secrets(js_content, url)
                    self.findings.extend(secrets)
                except Exception as e:
                    logger.error(f"Failed to extract secrets from {url}: {str(e)}")

    async def _run_vuln_scan(self):
        """Runs nuclei, dalfox etc."""
        # Example Nuclei call
        try:
            # output = Executor.run(["nuclei", "-target", self.target, "-jsonl", "-silent"])
            # vuln_data = Parser.parse_nuclei(output)
            # self.findings.extend(vuln_data)
            pass
        except ToolError:
            logger.warning("Vulnerability scanner failed, skipping...")

    async def _run_risk_analysis(self):
        # Normalize and Deduplicate (Point #7, #20)
        self.findings = Normalizer.deduplicate(self.findings)
        
        # Mapping and Scoring (Point #0, #5)
        for f in self.findings:
            f["owasp_category"] = map_to_owasp(f.get("type", "unknown"))
            f["risk_score"] = ml_risk_score(f)
            logger.info(f"Analyzed finding: {f['type']} | Risk: {f['risk_score']} | OWASP: {f['owasp_category']}")
