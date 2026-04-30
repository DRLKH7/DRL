from sqlalchemy import Column, String, Integer, DateTime, JSON, ForeignKey
from sqlalchemy.orm import relationship
from .database import Base
from datetime import datetime
import uuid

class User(Base):
    __tablename__ = "users"
    id = Column(String, primary_key=True, default=lambda: str(uuid.uuid4()))
    username = Column(String, unique=True, index=True)
    email = Column(String, unique=True, index=True)
    hashed_password = Column(String)
    scans = relationship("Scan", back_populates="owner")

class Scan(Base):
    __tablename__ = "scans"
    id = Column(String, primary_key=True, default=lambda: str(uuid.uuid4()))
    target = Column(String)
    target_hash = Column(String, index=True, nullable=True)
    mode = Column(String)
    config_snapshot = Column(JSON, nullable=True)
    status = Column(String, default="PENDING")
    progress = Column(Integer, default=0)
    current_step = Column(String, default="INITIALIZING")
    findings = Column(JSON, default=[])
    created_at = Column(DateTime, default=datetime.utcnow)
    last_scan_at = Column(DateTime, default=datetime.utcnow)
    finished_at = Column(DateTime, nullable=True)
    parent_scan_id = Column(String, ForeignKey("scans.id"), nullable=True)
    user_id = Column(String, ForeignKey("users.id"))
    owner = relationship("User", back_populates="scans")

class VulnerabilityFingerprint(Base):
    __tablename__ = "vulnerability_fingerprints"
    id = Column(Integer, primary_key=True, autoincrement=True)
    fingerprint = Column(String(64), unique=True, index=True) # SHA256 of endpoint+vuln_type+parameter
    first_seen_scan_id = Column(String, ForeignKey("scans.id"))
    last_seen_scan_id = Column(String, ForeignKey("scans.id"))
