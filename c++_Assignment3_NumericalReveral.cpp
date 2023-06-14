/*==========================================================

 Title:       Assignment 3 - Numerical Reversal
 Course:      CIS 2252
 Author:      < Fatima Mohammed>
 Date:        < 6/1/23 >
 Description: This program takes 2 inputs. The first is the size of your array.
              The second is the int values of the array in format x,x,x,x,x,....
              Then the progam will print the results of the array backwards.
 ==========================================================
*/

#include <iostream>
#include <string>
using namespace std;

int main() {
    
  //write your solution here
  //define variables
  //int sizeofArray;
  
  //need to account for spaces
  //no you don't they are accounted for
  //problems when you don't initialize variables
  //output was memory instead of values at index
  int num=0;
  
  int sizeofArray=0;

  //ask user for size of array
  cin >> sizeofArray;
  
  //size = 6
  //_ _ _ _ _ _
  //0 1 2 3 4 5
  
  //initialize array here after userinput
  //can't set it earlier then change it later, code doesnt work
  int array[sizeofArray];

  //ask user to input values here based on sizeofArray
  //i think this works now!!!!!
  for (int i=0; i < sizeofArray; ++i) {
      
      //for each index, populate the array
      cin >> array[i];
  }//end of populate array
  
  /*
  //test that the array was set up correctly with the loop
  //cout << "\nprint array \n";
  
  //array is being stored properly
  //this took me 10 hours, why!!!
  //print the array
  for (int k=0; k < sizeofArray; ++k) {
      cout << array[k];
  }//end of print array
  */
    
  //output values of the array backwards
  //cout << "\nbackwards array \n";
  
  //testing the loop
  //j=5, sizeofArray
  //run loop until 0, the first element of the array
  //
  
  for (int j=sizeofArray-1; j > -1; j--) {
      
      cout << array[j] << " ";
  }//end of print backwards array
                   
  return 0;
}//end of main











