public class Main {
    public static void main(String[] args) {
        LRUCache cache = new LRUCache(10);

        for (int i = 0; i < 19; i++) {

            cache.put(i, i + 1);
            cache.showList();
        }

        for (int i = 0; i < 20; i++) {
            System.out.println(i + " " + (cache.containsKey(i) ? "true" : "false"));
        }

    }
}
