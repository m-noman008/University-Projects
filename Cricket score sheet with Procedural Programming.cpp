#include<iostream>
#include<cstdlib>
#include<ctime>
#include<string>
using namespace std;

const int MAX_PLAYERS = 11;
int TOTAL_BALLS;

struct Team
{
    string name;
    string players[MAX_PLAYERS];
    int runs;
    int wickets;
    int balls;
};

void inputTeam(Team *t);
int toss(Team *t1, Team *t2);
void playInnings(Team *batting,int target);
void scoreBoard(Team *t,int target);

int main()
{
    Team team1, team2;

    cout<<"=========== SIMPLE TWO INNINGS CRICKET SYSTEM ===========\n";

    cout<<"Enter Total Overs: ";
    int overs;
    cin>>overs;
    TOTAL_BALLS = overs * 6;

    cin.ignore(); // clear buffer before string input

    inputTeam(&team1);
    inputTeam(&team2);

    int tossWinner = toss(&team1,&team2);

    Team *batFirst;
    Team *batSecond;

    if(tossWinner==1)
    {
        batFirst=&team1;
        batSecond=&team2;
    }
    else
    {
        batFirst=&team2;
        batSecond=&team1;
    }

    cout<<"\n===== FIRST INNINGS =====\n";
    playInnings(batFirst,0);

    int target = batFirst->runs + 1;

    batSecond->runs=0;
    batSecond->wickets=0;
    batSecond->balls=0;

    cout<<"\n===== SECOND INNINGS =====\n";
    cout<<"Target = "<<target<<endl;
    playInnings(batSecond,target);

    cout<<"\n=========== MATCH RESULT ===========\n";

    if(batSecond->runs >= target)
        cout<<"WINNER: "<<batSecond->name<<"  |  STATUS: WIN\n";
    else if(batFirst->runs > batSecond->runs)
        cout<<"WINNER: "<<batFirst->name<<"  |  STATUS: WIN\n";
    else
        cout<<"MATCH STATUS: TIE\n";

    return 0;
}

// INPUT TEAM
void inputTeam(Team *t)
{
    do
    {
        cout<<"\nEnter Team Name: ";
        getline(cin,t->name);

        if(t->name.empty())
            cout<<"Please input the name. Field cannot be empty.\n";

    }while(t->name.empty());

    for(int i=0;i<MAX_PLAYERS;i++)
    {
        do
        {
            cout<<"Enter Player "<<i+1<<" Name: ";
            getline(cin,t->players[i]);

            if(t->players[i].empty())
                cout<<"Please input the name. Field cannot be empty.\n";

        }while(t->players[i].empty());
    }

    t->runs=0;
    t->wickets=0;
    t->balls=0;
}

// TOSS
int toss(Team *t1, Team *t2)
{
    srand(time(0));
    int r = rand()%2;

    if(r==0)
    {
        cout<<"\nToss Won By "<<t1->name<<endl;
        return 1;
    }
    else
    {
        cout<<"\nToss Won By "<<t2->name<<endl;
        return 2;
    }
}

// PLAY INNINGS
void playInnings(Team *batting,int target)
{
    while(batting->balls < TOTAL_BALLS && batting->wickets <10)
    {
        if(target!=0 && batting->runs>=target)
            break;

        scoreBoard(batting,target);

        cout<<"\n0 Dot\n1 Single\n2 Double\n3 Triple\n4 Four\n6 Six\n7 Wicket\nChoice: ";
        int choice;
        cin>>choice;

        switch(choice)
        {
            case 0: batting->balls++; break;
            case 1: batting->runs+=1; batting->balls++; break;
            case 2: batting->runs+=2; batting->balls++; break;
            case 3: batting->runs+=3; batting->balls++; break;
            case 4: batting->runs+=4; batting->balls++; break;
            case 6: batting->runs+=6; batting->balls++; break;
            case 7: batting->wickets++; batting->balls++; break;
            default: cout<<"Invalid Ball\n";
        }
    }

    cout<<"\nInnings Over! Score = "<<batting->runs<<endl;
}

// SCOREBOARD
void scoreBoard(Team *t,int target)
{
    int over = t->balls/6;
    int ball = t->balls%6;

    cout<<"\n--------------------------------";
    cout<<"\n"<<t->name<<" "<<t->runs<<"/"<<t->wickets;
    cout<<" ("<<over<<"."<<ball<<" overs)";
    if(target!=0)
        cout<<"\nNeed "<<target-t->runs<<" runs";
    cout<<"\n--------------------------------\n";
}

