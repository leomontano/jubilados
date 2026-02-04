<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class BackupController extends Controller
{
    
    public function index()
    {
        return view('backup.index');
    }

    public function runFTP(Request $request)
    {
        try {
            $fileName = 'backup_' . date('Y_m_d_His') . '.sql';
            $filePath = storage_path('app/backups/' . $fileName);

            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0777, true);
            }
           // $mysqldumpPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe";
            $mysqldumpPath =env('MYSQL_BASE_PATH');
            $command = sprintf(
                $mysqldumpPath . ' -u%s -p%s %s > %s',
                escapeshellarg(env('DB_USERNAME')),
                escapeshellarg(env('DB_PASSWORD')),
                escapeshellarg(env('DB_DATABASE')),
                escapeshellarg($filePath)
            );

            system($command);


            $ftp_server=env('SFTP_HOST');
            $ftp_user=env('SFTP_USERNAME');
            $ftp_pass=env('SFTP_PASSWORD');
            $remote_dir=env('SFTP_ROOT');
            $local_file=$filePath;
            $remote_file=$fileName;



            // SFTP_HOST=apiconphp.com
            // SFTP_USERNAME=u479214796.admin
            // SFTP_PASSWORD=k]C*SvDd1
            // SFTP_PORT=22
            // SFTP_ROOT=/public_html/jubilados/backup

            // $ftp_server = "ftp.example.com";

            // Establecimiento de una conexión
            $conn_id = ftp_connect($ftp_server); // or die("No se puede conectar al servidor $ftp_server");

            if($conn_id) {
                // $conn_id = ftp_connect($ftp_server);
                $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

               // var_dump($login_result);

                // Subir archivo
                if ($login_result && ftp_put($conn_id, $remote_file, $local_file, FTP_ASCII)) {
              //  echo "Archivo subido correctamente a la carpeta específica.";
                    $mensaje = 'Respaldo realizado con éxito:'.$fileName;

                } else {
                    // echo "Error al subir el archivo.";
                    $mensaje = 'Error al subir el archivo. No se completó el respaldo, revise conexión de internet y vuelva a intentar';
                }
                // Cerrar conexión
                ftp_close($conn_id);

                return response()->json([
                    'success' => true,
                    'message' => $mensaje
                ]);
            } else {
                $mensaje = 'No pude conectarme al servidor, revisa conexión a internet y reintenta';
                return response()->json([
                    'error' => true,
                    'message' => $mensaje
                ]);                
            }


            // $remotePath = $fileName;
            // Storage::disk('sftp')->put($remotePath, file_get_contents($filePath));

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Respaldo generado y subido con éxito.'
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }    

}
