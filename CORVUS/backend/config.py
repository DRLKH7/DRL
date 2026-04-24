import os
from pydantic_settings import BaseSettings
from typing import List

class Settings(BaseSettings):
    APP_NAME: str = "Corvus"
    APP_ENV: str = "development"
    DATABASE_URL: str = "postgresql://corvus:corvus@localhost:5432/corvus_db"
    REDIS_URL: str = "redis://localhost:6379/0"
    
    # Scan Limits
    MAX_CONCURRENT_SCAN: int = 3
    SCAN_TIMEOUT: int = 300
    QUEUE_LIMIT: int = 10
    
    # Target Scope Control
    MAX_URL: int = 500
    MAX_DEPTH: int = 3
    EXCLUDE_PATHS: List[str] = ["/logout", "/admin"]
    
    # Security
    JWT_SECRET: str = "supersecretkeychangeinproduction"
    ALGORITHM: str = "HS256"
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 60 * 24 # 1 day
    
    # Rate Limiting
    RATE_LIMIT_PER_USER_DAY: int = 5
    COOLDOWN_BETWEEN_SCANS_SEC: int = 60
    
    # CORS
    CORS_ORIGINS: List[str] = [
        "http://localhost:3000", 
        "http://localhost:5173",
        "https://corvusnoct.my.id",
        "http://corvusnoct.my.id"
    ]

    class Config:
        env_file = ".env"

settings = Settings()
