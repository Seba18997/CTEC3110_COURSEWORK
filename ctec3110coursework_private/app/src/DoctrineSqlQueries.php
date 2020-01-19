<?php


namespace M2MAPP;


class DoctrineSqlQueries
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param $queryBuilder
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     */

    public static function queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password)
    {
        $store_result = [];
        $username = $cleaned_parameters['sanitised_username'];
        $email = $cleaned_parameters['sanitised_email'];

        $queryBuilder = $queryBuilder->insert('user_data')
            ->values([
                'user_name' => ':name',
                'email' => ':email',
                'password' => ':password',
                'role' => ':role',
            ])
            ->setParameters([
                ':name' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':role' => 'user'
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    /**
     * @param $queryBuilder
     * @param string $cleaned_username
     * @return mixed
     */
    public static function querySelectUsername($queryBuilder, string $cleaned_username)
    {
        $queryBuilder = $queryBuilder->select('user_name')
            ->from('user_data')
            ->where("user_name = :username")
            ->setParameter('username', $cleaned_username);

        $store_result = $queryBuilder->execute()->rowCount();

        return $store_result;
    }
}