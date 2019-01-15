@echo off
set /p "cari=Cari String : "
if exist results.txt del /a /f results.txt
for /f "tokens=*" %%G in ('dir /b /s /a *.php') do (
	findstr /m /c:"%cari%" "%%G" >> results.txt
	if %errorlevel%==0 (
		echo Found! logged files into results.txt
	) else (
		echo No matches found
	)
)