<?php
// ListContext.php (converted from React context to PHP logic)
session_start();

require_once 'utils.php'; // Include utility functions (e.g., getUserID())

class ListContext {
    private $listsKey;
    private $categoriesKey;

    public function __construct() {
        $userId = getUserID(); // Implement this based on your auth session
        $this->listsKey = "shopwise_lists_$userId";
        $this->categoriesKey = "shopwise_categories_$userId";

        if (!isset($_SESSION[$this->categoriesKey])) {
            $_SESSION[$this->categoriesKey] = $this->defaultCategories();
        }
        if (!isset($_SESSION[$this->listsKey])) {
            $_SESSION[$this->listsKey] = [];
        }
    }

    private function defaultCategories() {
        return [
            ["id" => "1", "name" => "Groceries", "isDefault" => true],
            ["id" => "2", "name" => "Beverages", "isDefault" => true],
            ["id" => "3", "name" => "Snacks", "isDefault" => true]
        ];
    }

    public function getLists() {
        return $_SESSION[$this->listsKey];
    }

    public function getCategories() {
        return $_SESSION[$this->categoriesKey];
    }

    public function createList($name, $budget) {
        $newList = [
            "id" => uniqid(),
            "name" => $name,
            "budget" => max(0, floatval($budget)),
            "createdAt" => date('c'),
            "items" => []
        ];
        $_SESSION[$this->listsKey][] = $newList;
        return $newList;
    }

    public function updateList($updatedList) {
        foreach ($_SESSION[$this->listsKey] as &$list) {
            if ($list['id'] === $updatedList['id']) {
                $list = $updatedList;
                break;
            }
        }
    }

    public function deleteList($id) {
        $_SESSION[$this->listsKey] = array_filter(
            $_SESSION[$this->listsKey],
            fn($list) => $list['id'] !== $id
        );
    }

    public function getCurrentList($id) {
        foreach ($_SESSION[$this->listsKey] as $list) {
            if ($list['id'] === $id) return $list;
        }
        return null;
    }

    public function addItem($listId, $item) {
        foreach ($_SESSION[$this->listsKey] as &$list) {
            if ($list['id'] === $listId) {
                $item['id'] = uniqid();
                $list['items'][] = $item;
                break;
            }
        }
    }

    public function updateItem($listId, $item) {
        foreach ($_SESSION[$this->listsKey] as &$list) {
            if ($list['id'] === $listId) {
                foreach ($list['items'] as &$i) {
                    if ($i['id'] === $item['id']) {
                        $i = $item;
                        break;
                    }
                }
                break;
            }
        }
    }

    public function removeItem($listId, $itemId) {
        foreach ($_SESSION[$this->listsKey] as &$list) {
            if ($list['id'] === $listId) {
                $list['items'] = array_filter(
                    $list['items'],
                    fn($i) => $i['id'] !== $itemId
                );
                break;
            }
        }
    }

    public function addCategory($name) {
        $_SESSION[$this->categoriesKey][] = [
            "id" => uniqid(),
            "name" => $name,
            "isDefault" => false
        ];
    }

    public function getTotalSpent($listId) {
        $list = $this->getCurrentList($listId);
        if (!$list) return 0;
        return array_reduce($list['items'], function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    }
}

// Utility to get user ID from session or fallbackunction getUserID() {
    return $_SESSION['user_id'] ?? 'guest';
}

?>