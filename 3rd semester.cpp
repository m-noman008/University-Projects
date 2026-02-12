#include<iostream>
#include<string>
#include<stack>
#include<queue>
#include<vector>
#include<map>
using namespace std;

#define MAX_PLAYERS 11

// ================= LINKED LIST (COMMENTARY) =================
class Node
{
public:
    string data;
    Node* next;
    Node(string d)
    {
        data=d;
        next=NULL;
    }
};

class CommentaryList
{
    Node* head;
public:
    CommentaryList(){ head=NULL; }

    void add(string text)
    {
        Node* newNode=new Node(text);
        if(!head) head=newNode;
        else
        {
            Node* temp=head;
            while(temp->next) temp=temp->next;
            temp->next=newNode;
        }
    }

    void display()
    {
        Node* temp=head;
        while(temp)
        {
            cout<<temp->data<<endl;
            temp=temp->next;
        }
    }
};

// ================= BINARY TREE (TOURNAMENT) =================
class MatchNode
{
public:
    string matchName;
    MatchNode* left;
    MatchNode* right;

    MatchNode(string name)
    {
        matchName=name;
        left=right=NULL;
    }
};

void showTournament(MatchNode* root)
{
    if(!root) return;
    cout<<root->matchName<<endl;
    showTournament(root->left);
    showTournament(root->right);
}

// ================= TEAM STRUCT =================
struct Team
{
    string name;
    string players[MAX_PLAYERS];
    int runs=0;
    int wickets=0;
    int balls=0;
};

// ================= GLOBAL DSA =================
stack<int> ballHistory;              // STACK
queue<string> battingOrder;          // QUEUE
CommentaryList commentary;           // LINKED LIST
map<string, vector<string>> graph;   // GRAPH

int TOTAL_BALLS;

// ================= INPUT TEAM =================
void inputTeam(Team &t)
{
    cin.ignore();
    do{
        cout<<"Enter Team Name: ";
        getline(cin,t.name);
    }while(t.name.empty());

    for(int i=0;i<MAX_PLAYERS;i++)
    {
        do{
            cout<<"Enter Player "<<i+1<<": ";
            getline(cin,t.players[i]);
        }while(t.players[i].empty());

        battingOrder.push(t.players[i]);
    }
}

// ================= SCOREBOARD =================
void showScore(Team &t)
{
    int over=t.balls/6;
    int ball=t.balls%6;
    cout<<"\n"<<t.name<<" "<<t.runs<<"/"<<t.wickets;
    cout<<" ("<<over<<"."<<ball<<" overs)\n";
}

// ================= INNINGS =================
void playInnings(Team &batting,int target)
{
    while(batting.balls<TOTAL_BALLS && batting.wickets<10)
    {
        if(target!=0 && batting.runs>=target) break;

        showScore(batting);

        cout<<"0 Dot |1|2|3|4|6 Runs |7 Wicket |9 Undo\nChoice: ";
        int c; cin>>c;

        if(c==9)
        {
            if(!ballHistory.empty())
            {
                ballHistory.pop();
                cout<<"Undo Last Ball\n";
            }
            continue;
        }

        ballHistory.push(c);
        commentary.add("Ball result: "+to_string(c));

        switch(c)
        {
            case 0: batting.balls++; break;
            case 1: batting.runs+=1; batting.balls++; break;
            case 2: batting.runs+=2; batting.balls++; break;
            case 3: batting.runs+=3; batting.balls++; break;
            case 4: batting.runs+=4; batting.balls++; break;
            case 6: batting.runs+=6; batting.balls++; break;
            case 7: batting.wickets++; batting.balls++; break;
            default: cout<<"Invalid\n";
        }
    }
}

// ================= MAIN =================
int main()
{
    cout<<"===== FINAL YEAR DSA CRICKET PROJECT =====\n";

    int overs;
    cout<<"Enter Overs: ";
    cin>>overs;
    TOTAL_BALLS=overs*6;

    Team t1,t2;

    inputTeam(t1);
    inputTeam(t2);

    // GRAPH
    graph[t1.name].push_back(t2.name);
    graph[t2.name].push_back(t1.name);

    // TOURNAMENT TREE
    MatchNode* finalMatch=new MatchNode("FINAL");
    finalMatch->left=new MatchNode("SEMI FINAL 1");
    finalMatch->right=new MatchNode("SEMI FINAL 2");

    cout<<"\n===== FIRST INNINGS =====\n";
    playInnings(t1,0);

    int target=t1.runs+1;

    cout<<"\n===== SECOND INNINGS =====\n";
    playInnings(t2,target);

    cout<<"\n===== RESULT =====\n";

    if(t2.runs>=target)
        cout<<"Winner: "<<t2.name<<" (WIN)\n";
    else if(t1.runs>t2.runs)
        cout<<"Winner: "<<t1.name<<" (WIN)\n";
    else
        cout<<"MATCH TIED\n";

    cout<<"\n===== COMMENTARY (Linked List) =====\n";
    commentary.display();

    cout<<"\n===== TOURNAMENT TREE =====\n";
    showTournament(finalMatch);

    cout<<"\n===== MATCH GRAPH =====\n";
    for(auto &g:graph)
    {
        cout<<g.first<<" played vs ";
        for(auto &x:g.second)
            cout<<x<<" ";
        cout<<endl;
    }

    return 0;
}

