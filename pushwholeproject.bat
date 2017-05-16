@echo off
color c
echo.
echo *********************** Push everything ***********************
echo.
set message=%date%_%username%
set /p "message = Your Commit-Message: "

git add .
git commit -m "%message%"
git push

pause >nul
exit