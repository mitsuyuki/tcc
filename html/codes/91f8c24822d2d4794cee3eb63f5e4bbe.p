import java.util.Scanner;
class main {
	public static void main(String args[]){
          Scanner entrada = new Scanner(System.in);
          int t = 1;
          int n = 3;
          for(int i=1;i<=10;i++){
             t = n * i;
             System.out.printf("%d x %d = %d\n",n,i,t);
          }
          System.out.println("Ola mundo!");
	}
}