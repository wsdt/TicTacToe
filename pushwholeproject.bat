@echo off
color c
echo.
echo *********************** Push everything ***********************
echo.


echo git add .
echo git commit -m [your message]
echo git push

echo.
set files=.
set /p "files=File to be added [. for whole project]: "

if "%files%" equ "." echo WARNING: ALL FILES ARE GOING TO BE OVERWRITTEN!!!
echo.
set message=%date%_%username%
set /p "message=Your Commit-Message: "

git add %files%
git commit -m "%message%"
git push

pause >nul
exit