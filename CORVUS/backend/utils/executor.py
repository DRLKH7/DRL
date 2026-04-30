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
    def run(command: List[str], timeout: int = 300, cwd: Optional[str] = None, scan_id: str = None, tool_name: str = None) -> str:
        """
        Runs a command and returns its stdout. Optionally saves output to file.
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
            
            stdout_content = process.stdout
            
            # Save raw output if requested
            if scan_id and tool_name:
                output_dir = os.path.join("tools_output", str(scan_id))
                os.makedirs(output_dir, exist_ok=True)
                output_path = os.path.join(output_dir, f"{tool_name}.txt")
                with open(output_path, "w", encoding="utf-8") as f:
                    f.write(f"Command: {' '.join(command)}\n")
                    f.write(f"Exit Code: {process.returncode}\n")
                    f.write(f"Duration: {duration:.2f}s\n")
                    f.write("-" * 40 + "\n")
                    f.write(stdout_content)
                    if process.stderr:
                        f.write("\n" + "=" * 20 + " STDERR " + "=" * 20 + "\n")
                        f.write(process.stderr)
            
            return stdout_content
            
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
