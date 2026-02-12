#include<windows.h>
#include<iostream>
#include<time.h>
using namespace std;
static int mn=10;
int BALLS,innings=1,target;                                     //static variable
template<class x> void MyTeam(x o);
template<class z> void Score_board(z &t);
int extra_choice(string);

class Live_Score
{
	public :
              // varialbles for match info
			string match_name,venue,result,series_type,team1,team2,toss_choice,toss_winner,toss_loser;
			 int n,total_overs,series_match_no,no_of_matches;
			 
			//variables for score card
			int total_runs;
			virtual void update_score_board(){}                                     // virtual function
			void toss_decision();
			void store_data();
			void display_data();
			void display()
	        {
	        	
	            label:
	            cout<<"------------------------------------------------------------------------------------------------------------";
	            cout<<endl<<"||                                  || UOG LIVE SCORING ||                                                ||\n";
	            cout<<"||--------------------------------------------------------------------------------------------------------||";
	        	cout<<endl<<"||                                Enter Tournament Type                                                   ||";
	        	cout<<endl<<"||                                                                                                        ||";
	        	cout<<endl<<"||1. Limited Overs series                                                                                 ||";
				cout<<endl<<"||2. Test_series                                                                                          ||";
				cout<<endl<<"||3. Tri_series                                                                                           ||";
				cout<<endl<<"||4. ICC Tournament                                                                                       ||";
				cout<<endl<<"||5.back                                                                                                  ||"<<endl;
				cout<<"||--------------------------------------------------------------------------------------------------------||"<<endl;
				cout<<"||only option 1 and 5 avilable                                                                            ||"<<endl;
	        	cout<<"||--------------------------------------------------------------------------------------------------------||"<<endl<<endl<<"\t\t";
				cin>>n;
				switch(n)
	        	{
				      case 1: limited_overs_series();
	        	          break;
	        	      case 2: limited_overs_series();
	        	          break;
					  case 3: limited_overs_series();
	        	          break;
					  case 4: limited_overs_series();
	        	          break;
	        	     
	                  default : cout<<endl<<"No such format exist...";
	                            goto label;
	            }   
			}
			void limited_overs_series()
			{
				system("cls");
				char ch;int a1;
				cout<<endl<<"SERIES  INFO"<<endl;
				cout<<endl<<"Overs : ";
				cin>>total_overs;
				BALLS=(total_overs)*6;
				cout<<endl<<"No. of Matches : ";
				cin>>no_of_matches;
				cin.ignore();
				cout<<endl<<"Team 1 : ";
				getline(cin,team1);
				cout<<endl<<"Team 2 : ";
				getline(cin,team2);	
				l1:
				cout<<endl<<"Match NO. : ";
				cin>>series_match_no;
				if(series_match_no==1){
				cin.ignore();
				cout<<endl<<"Venue : ";
				getline(cin,venue);
				toss_decision();
			    }
				else{
					cout<<"Record not found..!"<<endl;
					goto l1;
				}
			}
			void toss()
			{
				system("cls");
				char ch,*chr;
				int c;

				label:
				cout<<endl<<"It's Toss Time..."<<endl;
				system("cls");
				cout<<endl<<"It's "<<team1<<"'s call !!";
				cout<<endl<<"H or T ?"<<endl;
				cin>>ch;
				srand(time(0));
				c=(rand());                         // RANDOM FUNCTION
				if(ch=='H'||ch=='h')
				{
					if(c%2==0)
					{
						toss_winner=team1;
						toss_loser=team2;
						cout<<endl<<"Toss won by "<<team1;
						cout<<endl<<"What do you want to do? (ball/bat) = ";
						cin>>toss_choice;
						if(toss_choice=="bat"||toss_choice=="BAT"||toss_choice=="ball"||toss_choice=="BALL")
						cout<<endl<<team1<<" won the toss and decided to "<<toss_choice<<" first";
				    }
					else
					{
					 	toss_winner=team2;
					 	toss_loser=team1;
						cout<<endl<<"Toss won by "<<team2;
						cout<<endl<<"What do you want to do? (ball/bat) = ";
						cin>>toss_choice;
						if(toss_choice=="bat"||toss_choice=="BAT"||toss_choice=="ball"||toss_choice=="BALL")
						cout<<endl<<endl<<team2<<" won the toss and decided to "<<toss_choice<<" first";
					}
				}
				else if(ch=='T'||ch=='t')
				{
					if(c%2==0)
					{
					    toss_winner=team1;
					    toss_loser=team2;
					    two:
						cout<<endl<<"Toss won by "<<team1;
						cout<<endl<<"What do you want to do? (ball/bat) = ";
						cin>>toss_choice;
						if(toss_choice=="bat"||toss_choice=="BAT"||toss_choice=="ball"||toss_choice=="BALL")
						cout<<endl<<team1<<" won the toss and decided to "<<toss_choice<<" first";
						else
						{
							cout<<endl<<"Invalid choice";
							goto two;
						}
				    }
					else
					{
						toss_winner=team2;
						toss_loser=team1;
						one:
						cout<<endl<<"Toss won by "<<team2;
						cout<<endl<<"What do you want to do? (ball/bat) = ";
						cin>>toss_choice;
						if(toss_choice=="bat"||toss_choice=="BAT"||toss_choice=="ball"||toss_choice=="BALL")
						cout<<endl<<team2<<" won the toss and decided to "<<toss_choice<<" first";
						else
						{
							cout<<endl<<"Invalid choice";
							goto one;
						}
					}
				}
				else
				{
					cout<<endl<<"Ase tu ni hota ha...";
				    goto label;
				}
			}



};

class Team1 : public Live_Score
{
	public :
			const int m;                                        
			int total_runs,balls,wickets,ex,over,ball,rem_balls,rem_runs;
			string name;
		     Team1(int a=10):m(a)                        
		     {
		     	mn++;
		     	total_runs=0;
				balls=0;
		        wickets=0;
				ex=0;
				ball=0;
				over=0;
			 }
			 friend void fun();
			void total_match() const                              	    
			{
				cout<<endl<<"Total matches so far... "<<m;
			}
			 template <class y>
			 friend void Score_board();                                   


			 void update_score_card()
		     {
		     	
		     	cout<<endl<<"*************"<<team1<<" vs "<<team2<<" Live from "<<venue<<"***********";
			   	if(ball>5)
			   	{
			   		ball=0;
				   over++;
				}
			   	cout<<endl<<team1<<"-"<<total_runs<<"/"<<wickets<<"   "<<"("<<over<<"."<<ball<<"overs)"<<" Extra :"<<ex;
			   	if(innings==2)
                    cout<<endl<<endl<<team1<<" require "<<rem_runs<<" runs of "<<rem_balls<<" balls "<<endl;
			 }
			  void run_score_board();
			  void next_inning();

}T1;

class Team2 :public Live_Score
{
	public :
			int total_runs,balls,wickets,ex,over,ball,rem_balls,rem_runs;
			string name;
			const int m;                                         
		    Team2(int a=10):m(a)                        
		    {
		     	mn++;
		     	total_runs=0;
				balls=0;
		        wickets=0;
				ex=0;
				ball=0;
				over=0;
			 }
			template <class y>
			friend void Score_board();                              //  generic Friend function
		     void update_score_card()
		     {
		     	//system("cls");
		     	cout<<endl<<"************"<<team2<<" vs "<<team1<<" Live from "<<venue<<"*************";
			   	if(ball>5)
			   	{
					ball=0;
				   over++;
			   }
				   cout<<endl<<endl<<team1<<"-"<<total_runs<<"/"<<wickets<<"   "<<"("<<over<<"."<<ball<<"overs)"<<" Extra : "<<ex;
				   if(innings==2)
                    cout<<endl<<endl<<team1<<" require "<<rem_runs<<" runs of "<<rem_balls<<" balls "<<endl;
			 }
			void run_score_board();
            void next_inning();

			 Team2& operator=(const Team1 t1)                                   
			 {
			 	Team2 temp;
			 	team1=t1.team2;
			 	team2=t1.team1;
			 	venue=t1.venue;
			 	series_match_no=t1.series_match_no;
			 	no_of_matches=t1.no_of_matches;
			 }
}T2;
void Team1::run_score_board()
{
	system("cls");
	cout<<endl<<" ********    Welcome To "<<team1<<" vs "<<team2<<" Match NO. "<<this->series_match_no<<" Live from "<<venue<<"   *******";
	cout<<endl<<endl<<this->team1<<"-"<<this->total_runs<<"/"<<this->wickets<<"   "<<"("<<this->over<<"."<<this->ball<<"overs)"<<" Extra : "<<this->ex;
	Sleep(1000);
	cout<<endl<<endl<<"R";
	Sleep(1000);
	cout<<" U ";
	Sleep(1000);
	cout<<" Ready.....";
	Score_board(T1);
}

void Team2::run_score_board()
{
	system("cls");
	cout<<endl<<" ********    Welcome To "<<team1<<" vs "<<team2<<" Match NO. "<<this->series_match_no<<" Live from "<<venue<<"   *******";
	cout<<endl<<endl<<this->team1<<"-"<<this->total_runs<<"/"<<this->wickets<<"   "<<"("<<this->over<<"."<<this->ball<<"overs)"<<" Extra : "<<this->ex;
	Sleep(1000);
	cout<<endl<<endl<<"R";
	Sleep(1000);
	cout<<" U ";
	Sleep(1000);
	cout<<" Ready.....";
	Score_board(T2);
}

void Team1:: next_inning()
{
    system("cls");
    target=T2.total_runs+1;
    rem_balls=BALLS;
    rem_runs=target;
    innings=2;
    cout<<endl<<"WELCOME TO SECOND INNINGS"<<endl<<endl<<"TARGET : "<<target;
    T1.run_score_board();
}

void Team2:: next_inning()
{
    system("cls");
    target=T1.total_runs+1;
    rem_balls=BALLS;
    rem_runs=target;
    innings=2;
    cout<<endl<<"WELCOME TO SECOND INNINGS"<<endl<<endl<<"TARGET : "<<target;
    T2.run_score_board();
}
template <class x> void MyTeam(x o)
{
	if(sizeof(o)==4)
	{
			T1.run_score_board();
		T2.next_inning();
	}else if(sizeof(o)==1)
	{
		T2.run_score_board();
		T1.next_inning();
	}
}
void Live_Score :: toss_decision()
{
	 int a=10;                        // for team1
	 char ch='a';                    // for team2
	 label:
	 toss();
	 T2=T1;                                       // operator overloding
	 if(toss_choice=="bat"||toss_choice=="BAT")
	 {

		if(toss_winner==team1)
	 		MyTeam(a);
	    else
		 	MyTeam(ch);
	 }
	 else if(toss_choice=="ball"||toss_choice=="BALL")
	 {
		if(toss_loser==team1)
	  	  MyTeam(a);
		else
		  MyTeam(ch);
     }

     else
	 {
	 cout<<endl<<"Invalid choice toss again...";
     goto label;
     }
}

template <class y>
void Score_board(y &t)
    {

		int c,c1,extra=0,freehit=0,prevball,achived=0;
		string type_e,type_w;
		while(t.balls<BALLS&&t.wickets<10&&achived==0)
		{
			system("cls");
			extra=0;
			if(freehit==1)
			prevball=(t.balls)-1;
			if(prevball!=(t.balls)-1)
			freehit=0;
			if(innings==2)
            {
                if(t.total_runs>=target)
                    achived=1;
            }
			t.update_score_card();
			cout<<endl<<endl<<"R U Ready for the next ball !!"<<endl;
			cout<<endl<<"0. Dot Ball"<<endl<<"1. Single"<<endl<<"2. Double"<<endl<<"3. Triple"<<endl<<"4. Four"<<endl
			<<"5. Extra"<<endl<<"6. Six"<<endl<<"7. Wickets"<<endl<<"8. Get_Score"<<endl;

			if(freehit==1)
                cout<<endl<<"It's a freehit"<<endl<<endl;
			cout<<endl<<"Result : ";
			cin>>c;
			extra=0;

			switch (c)
			{
				case  0:	t.balls++;
							t.ball++;
							if(innings==2)
                            {
                               t.rem_balls--;
                            }
							t.update_score_card();
								freehit=0;
							break;
				case  1: 	t.total_runs+=1;
							t.balls++;
								freehit=0;
							if(innings==2)
                            {
                                t.rem_balls--;
                                t.rem_runs--;
                            }
							t.ball++;
							t.update_score_card();
							break;
				case  2: 	t.total_runs+=2;
						    t.balls++;
						    	freehit=0;
							t.ball++;
							if(innings==2)
                            {
                                t.rem_balls--;
                                t.rem_runs-=2;
                            }
			                t.update_score_card();
							break;
		        case  3:    t.total_runs+=3;
						    t.balls++;
						    	freehit=0;
						    if(innings==2)
                            {
                                t.rem_balls--;
                                t.rem_runs-=3;
                            }
							t.ball++;
						    t.update_score_card();
						    break;
				case  4:    t.total_runs+=4;
						    t.balls++;
						    	freehit=0;
						    	if(innings==2)
                            {
                                t.rem_balls--;
                                t.rem_runs-=4;
                            }
							t.ball++;
						    t.update_score_card();
							break;
				case  5:    cout<<endl<<"Type of extra? ";
							cin.ignore();
							getline(cin,type_e);
						    cout<<endl<<"any other extra runs (0-6)? ";
							cin>>extra;
					        c1=extra_choice(type_e);
							switch(c1)
						    {
								case 1  : t.total_runs+=extra+1;
								 				t.ex+=extra+1;
								 					freehit=0;
								 					if(innings==2)
                                                    {
                                                        t.rem_runs-=(extra+1);
                                                    }
									  	        t.update_score_card();
											    break;
								case 2 :  t.total_runs+=extra+1;
                                                freehit=1;
									  	        t.ex+=1;
									  	        if(innings==2)
                                                {
                                                    t.rem_runs-=(extra+1);
                                                }
                                                cout<<endl<<"Its a free hit!!!"<<endl;
									  	        t.update_score_card();
									  	        break;
						 	    case 3  : t.total_runs+=extra;
		                                        t.ball++;
		                                        t.balls++;
		                                        	freehit=0;
		                                        t.ex+=extra;
		                                        if(innings==2)
                                                {
                                                    t.rem_balls--;
                                                    t.rem_runs-=extra;
                                                }
		                                        t.update_score_card();
		                                        break;
		                        case 4	:  t.total_runs+=extra;
		                                        t.ball++;
		                                        t.balls++;
		                                        	freehit=0;
		                                        t.ex+=extra;
		                                        if(innings==2)
                                                {
                                                    t.rem_balls--;
                                                    t.rem_runs-=extra;
                                                }
		                                        t.update_score_card();
		                                        break;
								default      :  t.total_runs+=extra;
										        t.ex+=extra;
										        t.balls++;
										        	freehit=0;
										        t.ball++;
										        if(innings==2)
                                                {
                                                    t.rem_balls--;
                                                    t.rem_runs-=extra;
                                                }
										        t.update_score_card();
							}
							break;
				case  6:    t.total_runs+=6;
						    t.balls++;
						    	freehit=0;
						    if(innings==2)
                            {
                                t.rem_balls--;
                                t.rem_runs-=6;
                            }
							t.ball++;
						    t.update_score_card();
							break;
				case  7:    cout<<endl<<"Type of wicket ? ";
						    cin.ignore();
							getline(cin,type_w);
							if(type_w=="runout"||type_w=="RUNOUT"||type_w=="run out"||type_w=="RUN OUT"||type_w=="stumping"||type_w=="STUMPING")
						    {
								char ch;
								cout<<endl<<"Any Extra (y-n)";
								cin>>ch;
								if(ch=='Y'||ch=='y')
								{
				                	cout<<endl<<"type of extra ?";
									cin>>type_e;
									c1=extra_choice(type_e);
									cout<<endl<<"Any extra run [0-6)";
									cin>>extra;
									switch(c1)
								    {
										case 1  : t.total_runs+=extra+1;
										 				t.ex+=extra+1;
										 				t.wickets++;
                                                        freehit=0;
                                                        if(innings==2)
                                                        {
                                                            t.rem_runs-=(extra+1);
                                                        }
											  	        t.update_score_card();
													    break;
										case 2 :  t.total_runs+=extra+1;
		                                                freehit=1;
											  	        t.ex+=extra+1;
											  	        t.wickets++;
											  	        if(innings==2)
                                                        {
                                                            t.rem_runs-=(extra+1);
                                                        }
											  	        cout<<endl<<"Its a free hit!!!"<<endl;
											  	        t.update_score_card();
											  	        break;
								 	    case 3  : t.total_runs+=extra;
				                                        t.ball++;
				                                        t.balls++;
				                                        t.ex+=extra;
				                                        t.wickets++;
                                                        freehit=0;
                                                        if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                            t.rem_balls--;

                                                        }
				                                        t.update_score_card();
				                                        break;
				                        case 4	:  t.total_runs+=extra;
				                                        t.ball++;
				                                        t.balls++;
				                                        t.ex+=extra;
				                                        t.wickets++;
                                                        freehit=0;
                                                        if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                            t.rem_balls--;
                                                        }
				                                        t.update_score_card();
				                                        break;
										default      :  t.total_runs+=extra;
												        t.ex+=extra;
												        t.balls++;
												        t.ball++;
												        freehit=0;
												        t.wickets++;
												        if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                            t.rem_balls--;
                                                        }
												        t.update_score_card();
									}
								}
								else
								{
									cout<<endl<<"any extra run in this runout?[0-6)";
                                    cin>>extra;
									t.total_runs+=extra;
                                    freehit=0;
									t.balls++;
									t.ball++;
									t.wickets++;
									if(innings==2)
                                    {
                                        t.rem_runs-=extra;
                                        t.rem_balls--;
                                    }
									t.update_score_card();
								}
						    }
							else
						    {
                                char ch;
								cout<<endl<<"is it a no ball ?? (y/n)";
								cin>>ch;
								if(freehit==0&&(ch=='N'||ch=='n'))
								{
							  	  t.wickets++;
								  t.balls++;
							      t.ball++;
                                  freehit=0;
                                  if(innings==2)
                                  {
                                    t.rem_balls--;
                                  }
							      t.update_score_card();
								}
								else	if(freehit==1&&(ch=='N'||ch=='n'))
								{
									cout<<endl<<"any extra runs on this free hit ?? (0-6)"<<endl;
						    		cin>>extra;
								  t.total_runs+=extra;
							      t.balls++;
							      t.ball++;
							      if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                            t.rem_balls--;
                                                        }
							      freehit=0;
							      t.update_score_card();
								}
								else	if(freehit==1&&(ch=='Y'||ch=='y'))
								{
									cout<<endl<<"any extra runs on this free hit ?? (0-6)"<<endl;
						    		cin>>extra;
						    		cout<<endl<<"It's a Freehit...."<<endl;
								  t.total_runs+=extra+1;
								  t.ex+=extra+1;
							      freehit=1;
							      if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                        }
							      t.update_score_card();
								}
								else	if(freehit==0&&(ch=='Y'||ch=='y'))
								{
									cout<<endl<<"any extra runs on this no ball ?? (0-6)"<<endl;
						    		cin>>extra;
						    		cout<<endl<<"It's a freehit"<<endl;
								  t.total_runs+=extra+1;
								  t.ex+=extra+1;
							      freehit=1;
							      if(innings==2)
                                                        {
                                                            t.rem_runs-=extra;
                                                        }
							      t.update_score_card();
								}


							}
							break;
                case 8 :        t.update_score_card();
                                break;

				default: cout<<endl<<"Dead ball"<<endl;

			}
		}
		extra=0;
		if(innings==1)
        {
            cout<<endl<<endl<<"Innings Over..."<<endl;
            cout<<endl<<t.team2<<" REQUIRE "<<t.total_runs+1<<" RUNS of "<<BALLS<<" BALLS "<<endl;
            cout<<endl<<"Wait for next inning...";
        }
        else
        {
            if(t.total_runs>=target)
            cout<<endl<<endl<<"******"<<t.team1<<" WON BY "<<10-t.wickets<<" wickets and "<<BALLS-t.balls<<" balls reamining *******"<<endl;
            else if(t.total_runs<target-1)
            {
                cout<<endl<<endl<<"******"<<t.team2<<" WON BY "<<(target-1)-t.total_runs<<"******";
            }
            else cout<<endl<<endl<<" MATCH IS TIED "<<endl;        }
}
int extra_choice(string s)
{
	int c;
	if(s=="wide"||s=="WIDE")
	c=1;
	else if(s=="no ball"||s=="NO BALL"||s=="noball"||s=="NOBALL")
    c=2;
	else if(s=="bye"||s=="BYE")
	c=3;
	else if(s=="legbye"||s=="LEGBYE"||s=="legbye"||s=="LEGBYE")
	c=4;
	else
	c=6;
	return c;
}

int main()
{
	system("color FA");
    T1.display();

	return 0;
}

