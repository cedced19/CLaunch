@ECHO OFF
SET BINDIR=%~dp0
CD /D "%BINDIR%"
"C:\Program Files (x86)\Java\jdk1.7.0_51\bin\java.exe" -Xmx1024M -Xms1024M -jar craftbukkit.jar
PAUSE