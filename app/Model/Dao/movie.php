<?php

namespace Model\Dao;
use Doctrine\DBAL\DBALException;
use PDO;

/**
 * Class User
 *
 * Userテーブルを扱う Classです
 * DAO.phpに用意したCRUD関数以外を実装するときに、記載をします。
 *
 * @copyright Ceres inc.
 * @author y-fukumoto <y-fukumoto@ceres-inc.jp>
 * @since 2018/08/28
 * @package Model\Dao
 */
class Movie extends Dao
{

    /**
     * getMovieList Function
     *
     * Movieテーブルにあるアイテム一覧を取得するためのサンプルです。
     *
     * @return array $result 結果情報を連想配列で指定します。
     * @throws DBALException
     * @since 2019/09/05
     */
    public function getItemList()
    {
        //全件取得するクエリを作成
        $sql = "select * from movie";

        // SQLをプリペア
        $statement = $this->db->prepare($sql);

        //SQLを実行
        $statement->execute();

        //結果レコードを全件取得し、返送
        return $statement->fetchAll();
    }
    /**
     * getMovie Function
     *
     * Movieテーブルから指定idのレコードを一件取得するクエリです。
     *
     * @param int $id 引数として、取得したい商品のアイテムIDを指定します。
     * @return array $result 結果情報を連想配列で指定します。
     * @throws DBALException
     * @since 2019/09/05
     */

    public function getItem($id)
    {

        //全件取得するクエリを作成
        $sql = "select * from movie where movie_id =:id";

        // SQLをプリペア
        $statement = $this->db->prepare($sql);

        //idを指定します
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        //SQLを実行
        $statement->execute();

        //結果レコードを一件取得し、返送
        return $statement->fetch();

    }
    public function getItemListOfUser($user_id)
    {
        //全件取得するクエリを作成
        $sql = "select * from movie where movie_user_id =:id";

        // SQLをプリペア
        $statement = $this->db->prepare($sql);

        //idを指定します
        $statement->bindParam(":id", $user_id, PDO::PARAM_INT);

        //SQLを実行
        $statement->execute();

        //結果レコードを一件取得し、返送
        return $statement->fetchAll();
    }
}
