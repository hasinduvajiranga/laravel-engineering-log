// app/Errors/Handler.php

namespace App\Errors;

use Illuminate\Auth\AuthException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ErrorBagHandler
{
    public function __construct()
    {
        $this->errorBag = new \Illuminate\Support\MessageBag();
    }

    public function handle(\Symfony\Component\HttpKernel\Event\RequestEvent $event)
    {
        $request = $event->getRequest();

        try {
            DB::connection()->getPdo()->queryException($request);
        } catch (\PDOException $e) {
            $this->errorBag->add('database', 'Database connection error');

            if ($e instanceof QueryException && $e->getCode() === 2295) {
                return;
            }

            throw $e;
        }

        try {
            DB::connection()->getPdo()->exec();
        } catch (\PDOException $e) {
            $this->errorBag->add('database', 'Database query error');

            if ($e instanceof QueryException && $e->getCode() === 2295) {
                return;
            }

            throw $e;
        }
    }
}