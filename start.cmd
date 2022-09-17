@echo off
TITLE Altay server software for Minecraft: Pocket Edition
cd /d %~dp0

set LOOP=true
set /A LOOPS=0

if exist bin\php\php.exe (
	set PHPRC=""
	set PHP_BINARY=bin\php\php.exe
) else (
	set PHP_BINARY=php
)

if exist Altay.phar (
	set POCKETMINE_FILE=Altay.phar
) else (
	if exist src\PocketMine.php (
		set POCKETMINE_FILE=src\PocketMine.php
	) else (
		echo "Couldn't find a valid Altay installation"
		pause
		exit 1
	)
)

if exist bin\mintty.exe (
	start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="Consolas" -o FontHeight=10 -o CursorType=0 -o CursorBlinks=1 -h error -t "Altay" -i bin/pocketmine.ico -w max %PHP_BINARY% %POCKETMINE_FILE% --enable-ansi %*
) else (
	REM pause on exitcode != 0 so the user can see what went wrong
	goto :start
)

:loop
if %LOOP% equ true (
    echo Restarted %LOOPS% times.
    echo To escape the loop, press CTRL+C now. Otherwise, wait 5 seconds for the server to restart.

    timeout 5

    set /A LOOPS+=1

    goto :start
) else (
    exit 0
)

:start
%PHP_BINARY% -c bin\php %POCKETMINE_FILE% %* || pause
goto :loop