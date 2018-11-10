import java.util.HashMap;

public class LRUCache {
    private HashMap<Integer, Integer> map = new HashMap<>();
    private List<Integer> list = new LinkedList<>();
    private int limitElements;

    LRUCache(int limitElements) {
        assert limitElements > 0;
        this.limitElements = limitElements;
    }

    public boolean containsKey(Integer key) {
        return map.containsKey(key);
    }

    public Integer put(Integer key, Integer value) {
        if (map.containsKey(key)) {
            return map.get(key);
        }

        addLast(key);
        if (list.size() > limitElements)
            removeFirst();

        return map.put(key, value);
    }

    public Integer get(Integer key) {
        updateToTop(key);
        assert list.peekLast().equals(key);
        return map.get(key);
    }

    private void updateToTop(Integer key) {
        removeFromList(key);
        addLast(key);
    }

    private void removeFirst() {
        list.removeFirst();
        map.remove(key);
    }

    private void addLast(Integer key) {
        list.push(key);
    }

    private void removeFromList(Integer key) {
        list.remove(key);
    }
}
