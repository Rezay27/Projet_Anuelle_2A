/*
 * Test of QR Code generator lib from Nayuki. (MIT License)
 * https://www.nayuki.io/page/qr-code-generator-library
 * Lib is Copyright (c) Project Nayuki. (MIT License)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * - The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 * - The Software is provided "as is", without warranty of any kind, express or
 *   implied, including but not limited to the warranties of merchantability,
 *   fitness for a particular purpose and noninfringement. In no event shall the
 *   authors or copyright holders be liable for any claim, damages or other
 *   liability, whether in an action of contract, tort or otherwise, arising from,
 *   out of or in connection with the Software or the use or other dealings in the
 *   Software.
 *
 *  This program generate and save a QrCode as a bmp.
 *
 *
 */
#ifdef WIN32
#include <windows.h>
#endif // WIN32
#include <stdbool.h>
#include <stddef.h>
#include <stdio.h>
#include <stdlib.h>

#include "qrcodegen.h"
#include <SDL/SDL.h>

#include <gtk/gtk.h>
#include <string.h>

#include <MYSQL/mysql.h>

#define QRNAMESIZE 255
#define IDSIZE 21

#define TYPE_INSERT 1
#define TYPE_SELECT 2
#define TYPE_UPDATE 3
//prototipage de la structure
typedef struct BirthDate{
    char day[3];
    char month[3];
    char year[5];
}BirthDate;

typedef struct Intervenant {
    char id[IDSIZE];
    char name[46];
    char nickname [46];
    BirthDate birthDate;
    char mail[256];
    char phone[11];
    char postalCode[6];
    char town[46];
    char address[46];
    char qrName[QRNAMESIZE];
} Intervenant;



// prototypages des fonctions
int myfgets (char *,int);
void encodeQr(char *, char *);
void createId(Intervenant *);
int printSdlQr(const uint8_t qrcode[],char*);
void generateQrName(Intervenant *);
int tabCharSize(char []);
void mainMysql(int ,Intervenant*);
void sqlInsert(Intervenant*,MYSQL*);
void sqlSelect(Intervenant*,MYSQL*);
void sqlUpdate(Intervenant *,MYSQL *);


//Enregistrement
Intervenant gonnaBeRegister;

GtkWidget *idEntry;
GtkWidget *qrnameEntry;
GtkWidget *qrcodeImage;

//Modification
Intervenant userChange;

GtkWidget *mname;
GtkWidget *mnickname;
GtkWidget *mmail;
GtkWidget *mphone;
GtkWidget *mday;
GtkWidget *mmonth;
GtkWidget *myear;
GtkWidget *mtown;
GtkWidget *maddress;
GtkWidget *mpostalcode;



int main(int argc, char *argv[]) {

    freopen("con", "w", stdout);

    GtkBuilder *builder;
    GtkWidget *window;

    gtk_init(&argc, &argv);


    builder = gtk_builder_new();
    gtk_builder_add_from_file(builder,"GtkApp1.glade",NULL);
    window= GTK_WIDGET(gtk_builder_get_object(builder,"mainWindow"));
    gtk_builder_connect_signals(builder,NULL);
    idEntry= GTK_WIDGET(gtk_builder_get_object(builder,"id"));
    qrnameEntry= GTK_WIDGET(gtk_builder_get_object(builder,"qrname"));
    qrcodeImage= GTK_WIDGET(gtk_builder_get_object(builder,"qrCode"));
    gtk_image_set_from_file(GTK_IMAGE(qrcodeImage),"Qr\\Qr.bmp");

    mname= GTK_WIDGET(gtk_builder_get_object(builder,"mnameEntry"));
    mnickname= GTK_WIDGET(gtk_builder_get_object(builder,"mnicknameEntry"));
    mmail= GTK_WIDGET(gtk_builder_get_object(builder,"mmailEntry"));
    mphone= GTK_WIDGET(gtk_builder_get_object(builder,"mphoneEntry"));
    mday= GTK_WIDGET(gtk_builder_get_object(builder,"mdayEntry"));
    mmonth= GTK_WIDGET(gtk_builder_get_object(builder,"mmonthEntry"));
    myear= GTK_WIDGET(gtk_builder_get_object(builder,"myearEntry"));
    mtown= GTK_WIDGET(gtk_builder_get_object(builder,"mtownEntry"));
    maddress= GTK_WIDGET(gtk_builder_get_object(builder,"maddressEntry"));
    mpostalcode= GTK_WIDGET(gtk_builder_get_object(builder,"mpostalcodeEntry"));


    g_object_unref(builder);

    gtk_widget_show(window);
    gtk_main();

	return 0;
}




// Creer un Qrcode et l'affiche dans une fenetre SDL ///////// A modifier pour permettre une entrer dans la console pour le texte
void encodeQr(char* text,char* name) {
	enum qrcodegen_Ecc errCorLv1 = qrcodegen_Ecc_LOW;  // Error correction level /C'est a dire tolerance a l'erreur du QrCode
	// Make and print the QR Code symbol
	uint8_t qrcode[qrcodegen_BUFFER_LEN_MAX]; //creation du tableau de stockage du QrCode
	uint8_t tempBuffer[qrcodegen_BUFFER_LEN_MAX]; //creation d'un tableau a usage temporaire
	bool ok = qrcodegen_encodeText(text, tempBuffer, qrcode, errCorLv1,
		qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
	if (ok)
		printSdlQr(qrcode,name);//Fonction de la partie affichage du QrCode qui creer celui ci au format bmp
}






// Affiche le qr code sur une interface SDL et l'enregistre automatiquement en SDL
int printSdlQr(const uint8_t qrcode[],char* name) {
    char dest[255];
	int qrSize = qrcodegen_getSize(qrcode);
	int border = 4;
	int y,x;
    int bSize = 10;
    int height = (qrSize +border*2)*bSize;
    int width = (qrSize + border*2 )*bSize;

    SDL_Surface * wBlock;
    wBlock = SDL_CreateRGBSurface(0,bSize,bSize,32,0,0,0,0);
    SDL_FillRect(wBlock,NULL,SDL_MapRGB(wBlock->format,255,255,255));
    SDL_Surface * bBlock;
    bBlock = SDL_CreateRGBSurface(0,bSize,bSize,32,0,0,0,0);
    SDL_FillRect(bBlock,NULL,SDL_MapRGB(bBlock->format,0,0,0));
    SDL_Rect b_pos;

    if ( SDL_Init( SDL_INIT_VIDEO ) < 0 )
    {
        printf( "Unable to init SDL: %s\n", SDL_GetError() );
        return 1;
    }


    // creation de la fenetre SDL
    SDL_Surface* screen = SDL_SetVideoMode(height, width, 16,
                                           SDL_HWSURFACE|SDL_DOUBLEBUF);
    if ( !screen )
    {
        printf("Unable to set video: %s\n", SDL_GetError());
        return 1;
    }


        // netoyage de l'ecran
        SDL_FillRect(screen, 0, SDL_MapRGB(screen->format, 0, 0, 0));

        // Dessin du QrCode
        for ( y = -border; y < qrSize+border ; y++) {
            for ( x = -border; x < qrSize+border; x++) {
                    b_pos.y=(y+border)*bSize;
                    b_pos.x=(x+border)*bSize;
                    qrcodegen_getModule(qrcode, x, y) ? SDL_BlitSurface(bBlock, 0, screen,&b_pos):SDL_BlitSurface(wBlock, 0, screen,&b_pos) ;
            }
        }

        strcpy(dest,"Qr\\");
        strcat(dest,name);
        SDL_SaveBMP(screen,dest);
        // fermeture de la fenetre SDL
        SDL_Quit();

    return 0;
}

void generateQrName(Intervenant * i){
    char temp[QRNAMESIZE];
    strcpy(temp,i->name);
    strcat(temp,i->nickname);
    strcat(temp,i->id);
    strcat(temp,"Qr.bmp\0");

    strcpy(i->qrName,temp);
}

void createId(Intervenant * i){
    char temp[IDSIZE];

    strcpy(temp,i->nickname);
    strcpy(temp+1,i->name);
    strcpy(temp+3,"_");
    strcat(temp,i->birthDate.day);
    strcat(temp,i->birthDate.month);
    strcat(temp,i->birthDate.year+1);

    strcpy(i->id,temp);
}

int myfgets (char * array,int size){
    if (array==NULL){
        return -1;
    }
    fflush(stdin);
    fgets(array,size,stdin);
    if (array[strlen(array)-1] =='\n'){
            array[strlen(array)-1] = '\0';
    }
    return 0;
}

G_MODULE_EXPORT void on_mainWindow_destroy()
{
    gtk_main_quit();
}


//Partie evenment enregistrement
//Bouton Insertion Intervenant
G_MODULE_EXPORT void on_generateQr_clicked(GtkButton *button){
    printf("salut");
    char dest[255];
    createId(&gonnaBeRegister);
    printf("id : %s\n",gonnaBeRegister.id);
    gtk_entry_set_text(GTK_ENTRY(idEntry),gonnaBeRegister.id);

    generateQrName(&gonnaBeRegister);
    printf("qrName : %s\n",gonnaBeRegister.qrName);
    gtk_entry_set_text(GTK_ENTRY(qrnameEntry),gonnaBeRegister.qrName);


	encodeQr(gonnaBeRegister.id,gonnaBeRegister.qrName);

	strcpy(dest,"Qr\\");
	strcat(dest,gonnaBeRegister.qrName);
	gtk_image_set_from_file(GTK_IMAGE(qrcodeImage),dest);
}

G_MODULE_EXPORT void on_register_clicked(GtkButton *button){
    mainMysql(TYPE_INSERT,&gonnaBeRegister);
}


//Gestion Formulaire Inscription Intervenant
G_MODULE_EXPORT void on_nameEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.name,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_nicknameEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.nickname,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_mailEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.mail,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_phoneEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.phone,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_dayEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.birthDate.day,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_monthEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.birthDate.month,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_yearEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.birthDate.year,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_townEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.town,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_addressEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.address,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_postalcodeEntry_changed(GtkEntry * entry){
    strcpy(gonnaBeRegister.postalCode,gtk_entry_get_text(entry));
}

//Partie evenement Modif

//Bouton
G_MODULE_EXPORT void on_update_clicked(GtkButton *button){
    mainMysql(TYPE_UPDATE,&userChange);
}

G_MODULE_EXPORT void on_get_clicked(GtkButton *button,GtkEntry * id){

    strcpy(userChange.id,gtk_entry_get_text(id));
    mainMysql(TYPE_SELECT,&userChange);

    gtk_entry_set_text(GTK_ENTRY(mname),userChange.name);
    gtk_entry_set_text(GTK_ENTRY(mnickname),userChange.nickname);
    gtk_entry_set_text(GTK_ENTRY(mmail),userChange.mail);
    gtk_entry_set_text(GTK_ENTRY(mphone),userChange.phone);
    gtk_entry_set_text(GTK_ENTRY(mtown),userChange.town);
    gtk_entry_set_text(GTK_ENTRY(maddress),userChange.address);
    gtk_entry_set_text(GTK_ENTRY(mpostalcode),userChange.postalCode);
    gtk_entry_set_text(GTK_ENTRY(myear),userChange.birthDate.year);
    gtk_entry_set_text(GTK_ENTRY(mmonth),userChange.birthDate.month);
    gtk_entry_set_text(GTK_ENTRY(mday),userChange.birthDate.day);



}


//Modif de champs
G_MODULE_EXPORT void on_mnameEntry_changed(GtkEntry * entry){
    strcpy(userChange.name,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_mnicknameEntry_changed(GtkEntry * entry){
    strcpy(userChange.nickname,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_mmailEntry_changed(GtkEntry * entry){
    strcpy(userChange.mail,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_mphoneEntry_changed(GtkEntry * entry){
    strcpy(userChange.phone,gtk_entry_get_text(entry));
}

G_MODULE_EXPORT void on_mdayEntry_changed(GtkEntry * entry){
    strcpy(userChange.birthDate.day,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_mmonthEntry_changed(GtkEntry * entry){
    strcpy(userChange.birthDate.month,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_myearEntry_changed(GtkEntry * entry){
    strcpy(userChange.birthDate.year,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_mtownEntry_changed(GtkEntry * entry){
    strcpy(userChange.town,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_maddressEntry_changed(GtkEntry * entry){
    strcpy(userChange.address,gtk_entry_get_text(entry));
}
G_MODULE_EXPORT void on_mpostalcodeEntry_changed(GtkEntry * entry){
    strcpy(userChange.postalCode,gtk_entry_get_text(entry));
}

void mainMysql(int queryType,Intervenant* i){// 1 : INSERT / 2 : SELECT
    MYSQL * mysql;
    const char *host = "127.0.0.1";
    const char *user = "root";
    const char *passwd = NULL;
    const char *dbname = "technicall";

    unsigned int port = 3306;
    const char *unix_socket = NULL;
    unsigned int flag = 0;

    mysql=mysql_init(NULL);
    mysql_options(mysql, MYSQL_READ_DEFAULT_GROUP, "option");
    if (mysql_real_connect(mysql,host,user,passwd,dbname,port,unix_socket,flag)){

        if (queryType == 1){
            sqlInsert(i,mysql);
        }
        else if (queryType == 2){
            sqlSelect(i,mysql);
        }
        else if(queryType==3){
            sqlUpdate(i,mysql);
        }

        mysql_close(mysql);
    }else{
        printf("Erreur de Connection a la base de donnee\n");
    }

}

void sqlInsert(Intervenant * i,MYSQL * mysql){
    char query[500];
    char date[12];

    strcpy(date,i->birthDate.year);
    strcat(date,"-");
    strcat(date,i->birthDate.month);
    strcat(date,"-");
    strcat(date,i->birthDate.day);

    sprintf(query, "INSERT INTO intervenant (id, nom, prenom, mail, telephone, codepostal, ville, adresse, nomQrCode, birthdate) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", i->id, i->name, i->nickname, i->mail, i->phone, i->postalCode, i->town, i->address, i->qrName, date);

    mysql_query(mysql,query);

    printf("La requete a bien ete effectuer\n");
}

void sqlSelect(Intervenant * i,MYSQL *mysql){
    char query[500];
    char date[12];
    MYSQL_RES *result =NULL;
    MYSQL_ROW row;

    int nbresult =0;

    sprintf(query, "SELECT nom, prenom, mail, telephone, codepostal, ville, adresse, birthdate FROM intervenant WHERE id = '%s' ",i->id);

    mysql_query(mysql,query);

    result = mysql_store_result(mysql);
    nbresult=mysql_num_rows(result);
    if (result==NULL||nbresult==0){
        printf("Erreur l'id en question n'existe pas\n");
        return NULL;
    }
    else{
        while((row = mysql_fetch_row(result))){

            strcpy(i->name,row[0]);
            strcpy(i->nickname,row[1]);
            strcpy(i->mail,row[2]);
            strcpy(i->phone,row[3]);
            strcpy(i->postalCode,row[4]);
            strcpy(i->town,row[5]);
            strcpy(i->address,row[6]);
            strcpy(date,row[7]);
            strncpy(i->birthDate.year,date,4);
            i->birthDate.year[4]="\0";
            strncpy(i->birthDate.month,date+5,2);
            i->birthDate.month[2]="\0";
            strcpy(i->birthDate.day,date+8);

        }

        mysql_free_result(result);


        printf("La requete a bien ete effectuer\n");
    }



}

void sqlUpdate(Intervenant * i,MYSQL *mysql){
    char query[500];
    char date[12];

    strcpy(date,i->birthDate.year);
    strcat(date,"-");
    strcat(date,i->birthDate.month);
    strcat(date,"-");
    strcat(date,i->birthDate.day);

    sprintf(query, "UPDATE intervenant SET nom = '%s', prenom = '%s', mail ='%s', telephone='%s', codepostal='%s', ville='%s', adresse='%s', birthdate='%s' WHERE id = '%s'", i->name, i->nickname, i->mail, i->phone, i->postalCode, i->town, i->address, date,i->id);

    mysql_query(mysql,query);

    printf("La requete a bien ete effectuer\n");
}
