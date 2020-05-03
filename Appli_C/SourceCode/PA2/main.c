

#ifdef WIN32
#include <windows.h>
#endif // WIN32
#include <MYSQL/mysql.h>
#include <stdio.h>
#include <stdlib.h>


void subDataBaseConnect(MYSQL *,char *[],char *[],char *[],char *[],int ,char * [],int,FILE * );
void transfertData(MYSQL *,MYSQL *,FILE *);

int main()
{
    MYSQL * mysql;
    const char *host = "127.0.0.1";
    const char *user = "root";
    const char *passwd = NULL;
    const char *dbname = "technicall";

    unsigned int port = 3306;
    const char *unix_socket = NULL;
    unsigned int flag = 0;
    mysql=mysql_init(NULL);

    FILE* file = NULL;

    file = fopen("log.txt", "w+");

    if (file != NULL)
    {
        fputs("=================================\nDebut Fusion", file);
    }
    mysql_options(mysql, MYSQL_READ_DEFAULT_GROUP, "option");
    if (mysql_real_connect(mysql,host,user,passwd,dbname,port,unix_socket,flag)){
        fprintf(file,"connection a la base de donnee principale effectuer\n");
        subDataBaseConnect(mysql,"127.0.0.1","root",NULL,"tech",3306,NULL,0,file);

        mysql_close(mysql);
        fprintf(file,"L'operation a bien été effectuer\n");
    }else{
        fprintf(file,"Erreur de Connection a la base de donnee Global\n");
    }
    fclose(file);
    return 0;

}

void subDataBaseConnect(MYSQL * dest,char *host[],char *user[],char *passwd[],char *dbname[],int port,char * unix_socket[],int flag,FILE* logfile){
    MYSQL * submysql;

    submysql=mysql_init(NULL);
    mysql_options(submysql, MYSQL_READ_DEFAULT_GROUP, "option");
    if (mysql_real_connect(submysql,host,user,passwd,dbname,port,unix_socket,flag)){
        fprintf(logfile,"connection a la base de donnée secondaire effectuer\n\n");
        transfertData(dest,submysql,logfile);

        mysql_close(submysql);
        fprintf(logfile,"fermetur submysql reussi !\n");
    }else{
        fprintf(logfile,"Erreur de Connection a la base de donnee secondaire\n");
    }
}

void transfertData(MYSQL * dest,MYSQL * from,FILE* logfile){
    char query[500];
    char date[12];
    MYSQL_RES *result =NULL;
    MYSQL_ROW row;

    int i;
    int nbresult =0;
    int champs=0;

    sprintf(query, "SELECT id, nom, prenom, mail, telephone, codepostal, ville, adresse, birthdate, nomQRCode  FROM intervenant");

    if(mysql_query(from,query)==0){
        fprintf(logfile,"Query de recuperation des information reussi\n");
        result = mysql_store_result(from);



        if (result==NULL){
            fprintf(logfile,"Erreur result = NULL\n");
            return NULL;
        }
        else{
            champs = mysql_num_fields(result);
            nbresult = mysql_num_rows(result);
            if (nbresult==0){
                fprintf(logfile,"erreur aucun resultat\n");
                return NULL;
            }
            while((row = mysql_fetch_row(result))){
                sprintf(query, "INSERT INTO intervenant (id, nom, prenom, mail, telephone, codepostal, ville, adresse, birthdate, nomQrCode) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7], row[8], row[9]);
                if(mysql_query(dest,query)==0){
                    fprintf(logfile,"La query : '%s' a bien ete executee\n",query);
                }
                else{
                    fprintf(logfile,"erreur sur la Query : '%s'\n",query);
                }
            }
        }
        mysql_free_result(result);
    }





}
