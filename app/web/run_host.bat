@echo off
title TransactionChain Web Server
set /p port=Port: 
php -S 127.0.0.1:%port%
pause