@echo off
color c
echo.
echo *********************** Push everything ***********************
echo.
echo WARNING: ALL FILES ARE GOING TO BE OVERWRITTEN!!!
echo.
echo git add .
echo git commit -m [your message]
echo git push

echo.
set message=%date%_%username%
set /p "message=Your Commit-Message: "

git add .
git commit -m "%message%"
git push

pause >nul
exit