import java.util.HashMap;

public class LRUCache {
    private HashMap<Integer, Integer> map = new HashMap<>();
    private Node head, tail;
    private int countElements = 0;
    private int limitElements;

    LRUCache(int limitElements) {
        assert limitElements > 0;

        this.limitElements = limitElements;
        head = new Node(-1);
        tail = new Node(-1);
        head.prev = tail;
        tail.next = head;
    }

    private class Node {
        Integer key;
        Node next, prev;

        Node(Integer key) {
            this.key = key;
            this.next = this.prev = null;
        }
        Node(Integer key, Node prev, Node next) {
            this.key = key;
            this.prev = prev;
            this.next = next;
        }
    }

    private void removeLast() {
        Integer key = tail.next.key;
        Node nextAfterRemoving = tail.next.next;
        nextAfterRemoving.prev = tail;
        tail.next = nextAfterRemoving;

        map.remove(key);
    }

    public boolean containsKey(Integer key) {
        return map.containsKey(key);
    }

    public void showList() {
        Node cur = tail;
        while (cur != head) {
            if (cur != tail)
                System.out.print(cur.key + " ");
            cur = cur.next;
        }
        System.out.println();
    }

    public Integer put(Integer key, Integer value) {
        if (map.containsKey(key)) {
            return map.get(key);
        }

        Node newElement = new Node(key, head, null);
        head.next = newElement;
        head = newElement;
        countElements++;

        if (countElements > limitElements) {
            removeLast();
            countElements--;
        }

        return map.put(key, value);
    }

    public Integer get(Integer key) {
        return map.get(key);
    }


}
