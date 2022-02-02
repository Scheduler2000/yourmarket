<?php
require_once('database_controller.php');
require_once(__DIR__ . '/../../model/product_feedback/product_feedback.php');
require_once(__DIR__ . '/../../model/product_feedback/feedback_informations.php');

class ProductFeedbackController extends DatabaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_feedback(ProductFeedback $feedback) /* 0 = success / 2 = error */
    {
        $sql = 'INSERT INTO product_feedback (item_id,rate,headline,comment,author_account_id) 
                VALUES (:item_id,:rate,:headline,:comment,:author_account_id)';

        $query = $this->_database->prepare($sql);

        return  $query->execute(array(
            'item_id' => $feedback->get_item_id(),
            'rate' => $feedback->get_rate(),
            'headline' => $feedback->get_headline(),
            'comment' => $feedback->get_comment(),
            'author_account_id' => $feedback->get_author_account_id()
        )) ? 0 : 2;
    }

    public function delete_feedbacks(int $product_id): bool
    {
        $sql = 'DELETE FROM product_feedback WHERE item_id = :pid';

        $query = $this->_database->prepare($sql);

        return $query->execute(array('pid' => $product_id));
    }

    public function get_feedbacks(int $product_id): ?array
    {
        $sql = 'SELECT * FROM product_feedback WHERE item_id = :item_id';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('item_id' => $product_id)))
            return null;

        return $query->fetchAll();
    }

    public function get_last_feedbacks(int $product_id, int $count): ?array
    {
        $sql = 'SELECT * FROM product_feedback WHERE item_id = :pid ORDER BY id ASC LIMIT :count';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('pid' => $product_id, 'count' => $count)))
            return null;

        return $query->fetchAll();
    }

    public function get_feedback_infos(int $product_id): ?FeedbackInformations
    {
        $sql_count = 'SELECT COUNT(*) FROM product_feedback WHERE item_id = :pid';

        $query_count = $this->_database->prepare($sql_count);

        if (!$query_count->execute(array('pid' => $product_id)))
            return null;

        $count = $query_count->fetchColumn();

        $sql_avg = 'SELECT AVG(rate) FROM product_feedback WHERE item_id = :pid';

        $query_avg = $this->_database->prepare($sql_avg);

        if (!$query_avg->execute(array('pid' => $product_id)))
            return null;

        $avg = $query_avg->fetch()[0];

        return new FeedbackInformations($count, $avg ?? 0);
    }
}
