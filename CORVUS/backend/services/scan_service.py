from sqlalchemy.orm import Session
from backend.db import models
from backend.queue.tasks import run_orchestrator_task
import re
import socket

def is_valid_target(target: str) -> bool:
    """ Validates target and checks for restricted IPs. """
    # 1. Clean target
    target = target.lower().replace("https://", "").replace("http://", "").split("/")[0]
    
    # 2. Check if valid hostname or IP
    try:
        ip = socket.gethostbyname(target)
    except socket.gaierror:
        return False
        
    # 3. Block private IPs
    private_patterns = [
        r"^127\.", r"^10\.", r"^172\.(1[6-9]|2[0-9]|3[0-1])\.", r"^192\.168\.",
        r"^169\.254\.", r"^0\.", r"^localhost$"
    ]
    
    for pattern in private_patterns:
        if re.match(pattern, ip) or re.match(pattern, target):
            return False
            
    return True

def get_active_scans_count(db: Session) -> int:
    return db.query(models.Scan).filter(models.Scan.status == "RUNNING").count()

def enqueue_scan(scan_id: str, target: str, mode: str):
    """ Enqueue task to Celery. """
    run_orchestrator_task.delay(scan_id, target, mode)
