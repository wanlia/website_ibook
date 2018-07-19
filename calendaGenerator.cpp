// print html code for the calenda 

#include <iostream>
using namespace std;
void printSimpleDate(int date){
	cout<<"\t<td>"<<date<<"</td>\n";
}
void printEventDate(int date){
	cout<<"\t<td class=\"date_has_event\">\n";
	cout<<"\t\t"<<date<<"\n";
	cout<<"\t\t<div class=\"events\">\n";
	cout<<"\t\t\t<ul>\n";
	cout<<"\t\t\t\t<li>\n";
	cout<<"\t\t\t\t\t<span class=\"title\">location</span>\n";
	cout<<"\t\t\t\t\t<span class=\"desc\">time</span>\n";
	cout<<"\t\t\t\t</li>\n";
	cout<<"\t\t\t</ul>\n";
	cout<<"\t\t</div>\n";
	cout<<"\t</td>\n";
}
int main ()
{
	int daysInMonth = 31;//enter the days in the month
	int offset = 1;//enter the offset first day of the month is not sunday
	int numberOfEventDays = 0; //enter the number of days we have consignment/sale events
	int eventDates[6] = {};//enter the dates of those events.
	
	
	//start printing
	cout<<"<tr>\n";
	if(offset)
		cout<<"\t<td class=\"padding\" colspan=\""<<offset<<"\"></td>\n";
	int j = 0;
	for(int i = 1; i <=  daysInMonth; i++){
		if(j < numberOfEventDays && eventDates[j] == i){
			printEventDate(i);
			j++;
		}else
			printSimpleDate(i);
		if((i+offset)%7 == 0)
			cout<<"</tr>\n<tr>\n";
	}
	cout<<"</tr>\n";
	return 0;
}