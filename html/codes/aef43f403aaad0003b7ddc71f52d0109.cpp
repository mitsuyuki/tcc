#include<iostream>

using namespace std;

int main() {
  int a,b,c,diff12,diff23;
  cin >> a >> b >> c;
  diff12 = b-a;
  diff23 = c-b;
  
  if(b < a && b >=c) {
  	cout << ":)" << endl;
  } else if(b > a && b <=c) {
  	cout << ":(" << endl;
  } else if(b > a && c > b && diff23 < diff12) {
  	cout << ":(" << endl;
  } else if(b > a && c > b && diff23 >= diff12) {
  	cout << ":)" << endl;
  } else if(b < a && c < b && diff23 < diff12) {
  	cout << ":)" << endl;
  } else if(b < a && c < b && diff23 >= diff12) {
  	cout << ":)" << endl;
  } else if(a == b && c > b) {
  	cout << ":)" << endl;
  } else if(a == b && c <= b) {
  	cout << ":(" << endl;
  }
  
	return 0;
}