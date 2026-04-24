import uvicorn
from fastapi import FastAPI, Depends, HTTPException, status
from fastapi.middleware.cors import CORSMiddleware
from backend.config import settings
from backend.api import routes, websocket, health
from backend.db.database import engine, Base
import logging

# Initialize DB (Simple way for dev, use Alembic for prod)
Base.metadata.create_all(bind=engine)

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(name)s: %(message)s",
    handlers=[logging.StreamHandler()]
)

app = FastAPI(
    title=settings.APP_NAME,
    version="1.0.0",
    docs_url="/api/docs",
    redoc_url="/api/redoc"
)

# CORS configuration
app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.CORS_ORIGINS,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Include Routers
app.include_router(routes.router, prefix="/api/v1", tags=["scans"])
app.include_router(health.router, prefix="/api/v1", tags=["system"])
app.include_websocket_router(websocket.router)

@app.on_event("startup")
async def startup_event():
    # Check dependencies (DB, Redis, Tools)
    logging.info("Corvus Backend starting up...")

if __name__ == "__main__":
    uvicorn.run("backend.app:app", host="0.0.0.0", port=8000, reload=True)
