<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
use App\GraphQL\MutationAbstract;
use Mockery\Exception;

class CreatePreOrderMutation extends MutationAbstract
{
    public function name()
    {
        return 'createPreOrder';
    }

    public function description()
    {
        return "Receive a wholesaler pre order and queue";
    }

    public function args()
    {
        return [
            'clientIdentification' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Client identification, CNPJ or CPF',
            ],
            'wholesaler'=> [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Wholesaler CNPJ',
            ],
            'clientCode' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Client code',
            ],
            'items' => ['type' => Type::nonNull(Type::listOf($this->itemType()))]
        ];
    }

    public function fields()
    {
        return [
            'status' => [
                'type' => Type::string(),
                'description' => 'The generated token',
            ],
        ];
    }

    protected function resolve()
    {
        return function ($root, $args) {
            return [
                'status'   => "ok",
            ];
        };
    }

    protected function itemType()
    {
        $itemType = new InputObjectType([
            'name' => 'item',
            'description' => 'Client identification, CNPJ os CPF',
            'fields' => [
                'ean' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The item EAN code'
                ],
                'quantity' => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'Quantity ordered'
                ],
                'wholesalerDiscount' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Wholesaler discount'
                ],
                'unitNetPrice' => [
                    'type' => Type::float(),
                    'description' => 'Unit net price'
                ],
            ]
        ]);

        return $itemType;
    }


}
