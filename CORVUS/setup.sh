#!/bin/bash

# Corvus setup script

echo "Initializing Corvus Platform..."

# 1. Create .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env from .env.example. Please update it with your settings."
fi

# 2. Build Docker containers
echo "Building Docker containers (this may take a few minutes)..."
docker-compose build

# 3. Start services
echo "Starting services..."
docker-compose up -d

echo "------------------------------------------------"
echo "Corvus is starting up!"
echo "API Docs: http://localhost:8000/api/docs"
echo "Frontend: http://localhost:5173 (once started)"
echo "------------------------------------------------"
echo "To view logs: docker-compose logs -f"
