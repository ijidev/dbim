@echo off
title DBIM Streaming Server
cd live-server

if not exist package.json (
    echo Initializing project...
    call npm init -y
    call npm install node-media-server
) else if not exist node_modules (
    echo Installing dependencies...
    call npm install
)

echo.
echo ===================================================
echo   DBIM LOCAL STREAMING SERVER
echo ===================================================
echo.
echo   1. Configure OBS Stream Settings:
echo      Server: rtmp://localhost/live
echo      Stream Key: (Copy from Admin Dashboard)
echo.
echo   2. Keep this window OPEN while streaming.
echo.
echo ===================================================
echo.

node index.js
pause
