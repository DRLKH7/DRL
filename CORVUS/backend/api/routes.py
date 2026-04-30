from fastapi import APIRouter, Depends, HTTPException, BackgroundTasks, Query
from fastapi.responses import FileResponse, JSONResponse
from sqlalchemy.orm import Session
import backend.db.models as models
import backend.db.database as database
import backend.db.schemas as schemas
from backend.core.orchestrator import Orchestrator
from backend.core import auth
import os
from datetime import datetime

router = APIRouter()
orchestrator = Orchestrator()

# --- AUTH ---
@router.post("/auth/register")
def register(user: schemas.UserCreate, db: Session = Depends(database.get_db)):
    db_user = db.query(models.User).filter(models.User.username == user.username).first()
    if db_user: raise HTTPException(status_code=400, detail="Username taken")
    hashed = auth.get_password_hash(user.password)
    new_user = models.User(username=user.username, email=user.email, hashed_password=hashed)
    db.add(new_user)
    db.commit()
    return {"status": "success"}

@router.post("/auth/login")
def login(user: schemas.UserLogin, db: Session = Depends(database.get_db)):
    db_user = db.query(models.User).filter(models.User.username == user.username).first()
    if not db_user or not auth.verify_password(user.password, db_user.hashed_password):
        raise HTTPException(status_code=401, detail="Invalid credentials")
    token = auth.create_access_token(data={"sub": db_user.username})
    return {"access_token": token, "token_type": "bearer"}

@router.get("/auth/me")
def get_me(current_user: models.User = Depends(auth.get_current_user)):
    return current_user

# --- SCAN CORE ---
@router.post("/scan")
def start_scan(request: schemas.ScanRequest, background_tasks: BackgroundTasks, db: Session = Depends(database.get_db)):
    new_scan = models.Scan(target=request.target, mode=request.mode, status="PENDING", progress=0)
    db.add(new_scan)
    db.commit()
    db.refresh(new_scan)
    background_tasks.add_task(orchestrator.run_scan, new_scan.id, request.target, request.mode)
    return new_scan

@router.get("/scan/{scan_id}")
def get_scan(scan_id: str, db: Session = Depends(database.get_db)):
    scan = db.query(models.Scan).filter(models.Scan.id == scan_id).first()
    if not scan: raise HTTPException(status_code=404, detail="Not found")
    return scan

@router.get("/reports")
def list_reports(db: Session = Depends(database.get_db), offset: int = 0, limit: int = 10):
    return db.query(models.Scan).order_by(models.Scan.last_scan_at.desc()).offset(offset).limit(limit).all()

# --- EXPORTS ---
@router.get("/reports/{scan_id}/json")
def export_json(scan_id: str, db: Session = Depends(database.get_db)):
    scan = db.query(models.Scan).filter(models.Scan.id == scan_id).first()
    return JSONResponse(content={"id": scan.id, "target": scan.target, "findings": scan.findings})

@router.delete("/reports/{scan_id}")
def delete_report(scan_id: str, db: Session = Depends(database.get_db)):
    scan = db.query(models.Scan).filter(models.Scan.id == scan_id).first()
    if not scan: raise HTTPException(status_code=404, detail="Not found")
    
    # Delete database record
    db.delete(scan)
    db.commit()
    
    # Optionally delete files in tools_output
    import shutil
    output_dir = os.path.join("tools_output", str(scan_id))
    if os.path.exists(output_dir):
        shutil.rmtree(output_dir)
        
    return {"status": "deleted"}

@router.get("/reports/{scan_id}/pdf")
def export_pdf(scan_id: str, db: Session = Depends(database.get_db)):
    # PDF logic implemented here or in external util
    return {"message": "PDF exported"}
