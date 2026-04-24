import subprocess
import time
import logging
import os
from typing import List, Optional

logger = logging.getLogger("corvus.executor")

class ToolError(Exception):
    pass

class Executor:
    """
    Executes external tools with timeout, resource limits, and error handling.
    """
    
    @staticmethod
    def run(command: List[str], timeout: int = 300, cwd: Optional[str] = None) -> str:
        """
        Runs a command and returns its stdout.
        """
        try:
            logger.info(f"Executing command: {' '.join(command)}")
            start_time = time.time()
            
            process = subprocess.run(
                command,
                capture_output=True,
                text=True,
                timeout=timeout,
                cwd=cwd,
                check=False # We handle status code manually
            )
            
            duration = time.time() - start_time
            logger.debug(f"Command finished in {duration:.2f}s with exit code {process.returncode}")
            
            if process.returncode != 0:
                logger.warning(f"Command '{' '.join(command)}' failed with exit code {process.returncode}")
                # We don't always raise ToolError because some tools return non-zero for found vulns
            
            return process.stdout
            
        except subprocess.TimeoutExpired:
            logger.error(f"Command timed out after {timeout}s: {' '.join(command)}")
            raise ToolError(f"Tool timeout: {' '.join(command)}")
        except Exception as e:
            logger.error(f"Unexpected error executing tool: {str(e)}")
            raise ToolError(f"Execution error: {str(e)}")

    @staticmethod
    def run_to_file(command: List[str], output_file: str, timeout: int = 300):
        """
        Runs a command and redirects output to a file.
        """
        try:
            with open(output_file, 'w') as f:
                subprocess.run(
                    command,
                    stdout=f,
                    stderr=subprocess.PIPE,
                    timeout=timeout,
                    check=False
                )
        except Exception as e:
            logger.error(f"Failed to run command to file: {str(e)}")
            raise ToolError(str(e))
