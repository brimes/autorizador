<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationAbstract;
use Mockery\Exception;

class CreateTokenMutation extends MutationAbstract
{
    public function name()
    {
        return 'createToken';
    }

    public function description()
    {
        return "Generate a new token";
    }

    public function args()
    {
        return [
            'username' => ['type' => Type::string()],
            'password' => ['type' => Type::string()]
        ];
    }

    public function fields()
    {
        return [
            'token' => [
                'type' => Type::string(),
                'description' => 'The generated token',
            ],
        ];
    }

    protected function resolve()
    {
        return function ($root, $args) {
            if ($args['username'] != 'teste' || $args['password'] != '1234') {
                throw new Exception("User bloqued", 401);
            }
            $newToken = $this->generateToken();
            $storageFileName = __DIR__ . "/../../../storage/token.json";
            file_put_contents($storageFileName, $newToken);
            return [
                'token'   => $newToken,
            ];
        };
    }

    protected function generateToken()
    {
        return uniqid();
    }
}
