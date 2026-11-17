@echo off
echo ========================================================
echo Menjalankan MySQL untuk Inventaris Kos...
echo ========================================================

if exist "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe" (
    echo Menjalankan MySQL dari Laragon (C:\laragon)...
    start "" "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe" --console
    goto done
)

if exist "C:\xampp\mysql\bin\mysqld.exe" (
    echo Menjalankan MySQL dari XAMPP (C:\xampp)...
    start "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --console
    goto done
)

if exist "D:\xampp\mysql\bin\mysqld.exe" (
    echo Menjalankan MySQL dari XAMPP (D:\xampp)...
    start "" "D:\xampp\mysql\bin\mysqld.exe" --defaults-file="D:\xampp\mysql\bin\my.ini" --console
    goto done
)

echo [ERROR] MySQL tidak ditemukan di direktori Laragon atau XAMPP.
pause
exit /b 1

:done
echo MySQL berhasil dijalankan di port 3306!
echo Silakan pastikan database 'db_inventaris_kos' sudah diimpor.
pause
