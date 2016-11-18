import java.util.*;
 
public class SortBasedFrequentNumber {
 
    public int getSecondMostFrequent(int[] arr) {
 
        Arrays.sort(arr);
 
        List<Frequency> list = new ArrayList<Frequency>();
        int previous = 0;
        Frequency f = null;
 
        for (int i = 0; i < arr.length; i++) {
            int num = arr[i];
 
            if (i == 0 || previous != num) {
                f = new Frequency(1, num);
                list.add(f);
                previous = num;
            } else {
                f.count = f.count + 1;
            }
        }
 
        Collections.sort(
                        list, 
                        new Comparator<Frequency>() {
                            public int compare(Frequency fr0, Frequency fr1) {
                                // sort in descending order
                                return fr1.count - fr0.count;
                            }
                        }
                    );
 
        int value = 0;
        if (list.size() > 1) {
            value = list.get(1).num;
        }
        return value;
    }
 
    private class Frequency {
        int count;
        int num;
 
        public Frequency(int count, int num) {
            this.count = count;
            this.num = num;
        }
    }

    public static void main (String [] args)
    {
      SortBasedFrequentNumber freq = new SortBasedFrequentNumber();
      System.out.println("Enter the size of the array");
      Scanner scanner = new Scanner(System.in);
      int size = scanner.nextInt();
      int[] arr = new int[size];
      System.out.println("Enter the elements of the array");
      for(int i=0; i< arr.length; i++)
      {
        arr[i] = scanner.nextInt();
      }
      int result = freq.getSecondMostFrequent(arr);

      System.out.println("the second most frequent integer is "+result);

    }
}
