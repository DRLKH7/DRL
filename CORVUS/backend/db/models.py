from sqlalchemy import Column, Integer, String, Boolean, DateTime, ForeignKey, JSON, Float, Text
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from .database import Base

class User(Base):
    __tablename__ = "users"
    id = Column(Integer, primary_key=True, index=True)
    username = Column(String, unique=True, index=True)
    hashed_password = Column(String)
    role = Column(String, default="user") # admin, user
    is_active = Column(Boolean, default=True)
    scans = relationship("Scan", back_populates="owner")

class Scan(Base):
    __tablename__ = "scans"
    id = Column(String, primary_key=True, index=True) # UUID
    user_id = Column(Integer, ForeignKey("users.id"))
    target = Column(String, index=True)
    mode = Column(String) # quick, normal, deep
    status = Column(String, default="PENDING") # PENDING, RUNNING, PARTIAL, FAILED, COMPLETED
    progress = Column(Integer, default=0)
    target_hash = Column(String)
    last_scan_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())
    version = Column(Integer, default=1)
    
    owner = relationship("User", back_populates="scans")
    findings = relationship("Vulnerability", back_populates="scan")
    jobs = relationship("Job", back_populates="scan")

class Job(Base):
    __tablename__ = "jobs"
    id = Column(String, primary_key=True, index=True) # Celery Task ID
    scan_id = Column(String, ForeignKey("scans.id"))
    status = Column(String)
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    
    scan = relationship("Scan", back_populates="jobs")

class Vulnerability(Base):
    __tablename__ = "vulnerabilities"
    id = Column(Integer, primary_key=True, index=True)
    scan_id = Column(String, ForeignKey("scans.id"))
    type = Column(String) # xss, sqlmap, etc.
    severity = Column(String) # INFO, LOW, MEDIUM, HIGH, CRITICAL
    source = Column(String) # tool name
    endpoint = Column(String)
    raw_data = Column(JSON)
    normalized_data = Column(JSON)
    confidence = Column(Float)
    owasp_category = Column(String)
    risk_score = Column(Float)
    
    scan = relationship("Scan", back_populates="findings")

class AuditLog(Base):
    __tablename__ = "audit_logs"
    id = Column(Integer, primary_key=True, index=True)
    user_id = Column(Integer, ForeignKey("users.id"))
    action = Column(String) # "SCAN_START", "SCAN_FAILED"
    target = Column(String)
    timestamp = Column(DateTime(timezone=True), server_default=func.now())
