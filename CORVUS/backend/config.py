import os
from pydantic_settings import BaseSettings
from typing import List

class Settings(BaseSettings):
    APP_NAME: str = "Corvus"
    APP_ENV: str = "development"
    DATABASE_URL: str = "sqlite:///./corvus_v3.db"
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
        "http://localhost",
        "http://localhost:3000",
        "http://localhost:5173",
        "http://127.0.0.1",
        "https://corvusnoct.my.id",
        "http://corvusnoct.my.id"
    ]

    # New Enhancement Settings
    SCAN_CACHE_TTL: int = 3600
    ENABLE_CUSTOM_VULNS: bool = True
    SAFE_RATE_LIMIT_REQUESTS: int = 5

    # Tool Paths (Assumes binaries in PATH or GOPATH/bin)
    SUBFINDER_PATH: str = "subfinder"
    HTTPX_PATH: str = "httpx"
    NAABU_PATH: str = "naabu"
    KATANA_PATH: str = "katana"
    GAU_PATH: str = "gau"
    FFUF_PATH: str = "ffuf"
    NUCLEI_PATH: str = "nuclei"
    DALFOX_PATH: str = "dalfox"
    SQLMAP_PATH: str = "sqlmap"
    GF_PATH: str = "gf"
    LOXS_PATH: str = "python3 ~/loxs/loxs.py" # Example path
    
    # Wordlists
    FFUF_WORDLIST: str = "/usr/share/wordlists/dirb/common.txt" # Default fallback

    class Config:
        env_file = ".env"

settings = Settings()
