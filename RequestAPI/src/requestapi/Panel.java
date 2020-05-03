package requestapi;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class Panel extends JPanel {
    private DataBase dataBase=null;



    public Panel(){

        this.setLayout(new BorderLayout());




        //Champs pour les parametres de la Bdd
        JPanel bddPanel=bddConnect();
        this.add(bddPanel,BorderLayout.NORTH);


        //Fin partie test Bdd

        //Debut Zone de Selection

        JPanel formPanel = new JPanel();
        formPanel.setLayout(new BorderLayout());
        this.add(formPanel,BorderLayout.CENTER);



        String[] tableSelection={"membre","services","intervenant","demandes","abonnement"};
        JComboBox<String> table = new JComboBox(tableSelection);


        JPanel internForm=new JPanel();
        internForm.setPreferredSize(new Dimension(getWidth(),300));
        internForm.setLayout(new BorderLayout());
        formPanel.add(internForm,BorderLayout.CENTER);



        JButton valider = new JButton("Valider");

        formPanel.add(table,BorderLayout.NORTH);
        formPanel.add(valider,BorderLayout.SOUTH);

        JTextArea reponsearea= new JTextArea(10,100);
        reponsearea.setEditable(false);
        this.add(new JScrollPane(reponsearea),BorderLayout.SOUTH);

        JCheckBox[][] demande = {
                {new JCheckBox("abonement")/*traitement special*/, new JCheckBox("nom"), new JCheckBox("prenom"), new JCheckBox("date_naissance"), new JCheckBox("email"), new JCheckBox("pseudo"), new JCheckBox("adresse"), new JCheckBox("ville"), new JCheckBox("code_postal"), new JCheckBox("date_creation")},
                {new JCheckBox("nom_role")/*traitement special*/,new JCheckBox("nom_service"), new JCheckBox("tarif")},
                {new JCheckBox("nom_role")/*traitement special*/, new JCheckBox("date_naissance")/*Renomage Requis*/ ,new JCheckBox("nom"),new JCheckBox("prenom"),new JCheckBox("mail"),new JCheckBox("telephone"),new JCheckBox("codepostal"),new JCheckBox("ville"),new JCheckBox("adresse")},
                {new JCheckBox("nom_membre")/*traitement special*/, new JCheckBox("nom_intervenant")/*traitement special*/, new JCheckBox("nom_service")/*traitement special*/, new JCheckBox("nom_demande"), new JCheckBox("nb_heure"), new JCheckBox("taux_horaire"), new JCheckBox("point_unite"), new JCheckBox("prix_demande"), new JCheckBox("point_demande"), new JCheckBox("type_demande"), new JCheckBox("date_demande"), new JCheckBox("heure"), new JCheckBox("ville"),new JCheckBox("code_postal"), new JCheckBox("adresse")  },
                {new JCheckBox("nom")/*traitement special*/,new JCheckBox("prix")/*traitement special*/, new JCheckBox("description")/*traitement special*/, new JCheckBox("nb_point")}
        };

        JPanel [] ligne = new JPanel[demande.length];
        for (int i = 0; i<ligne.length;i++){
            ligne[i]=new JPanel();
            ligne[i].setLayout(new FlowLayout());
            ligne[i].setPreferredSize(new Dimension(1100,100));
        }


        for(int i = 0; i<demande.length;i++) {
            for(int j=0; j<demande[i].length;j++){
                ligne[i].add(demande[i][j]);
            }
        }




        internForm.add(ligne[0],BorderLayout.NORTH);


        String [] cond1 = {"Pas de Where","nom","prenom","date_naissance","email","pseudo", "adresse","ville", "code_postal", "date_creation"};
        String [] cond2 = {"Pas de Where","nom_service", "tarif"};
        String [] cond3 = {"Pas de Where","date_naissance"/*Renomage Requis*/ ,"nom","prenom","mail","telephone","codepostal","ville","adresse"};
        String [] cond4 = {"Pas de Where","nom_membre"/*traitement special*/,"nom_demande", "nb_heure", "taux_horaire", "point_unite", "prix_demande", "point_demande", "type_demande","date_demande","heure", "ville","code_postal","adresse" };
        String [] cond5 = {"Pas de Where"};
        JComboBox<String>[] cond = new JComboBox[]{new JComboBox(cond1),new JComboBox(cond2),new JComboBox(cond3),new JComboBox(cond4),new JComboBox(cond5)};

        String[] tabSymbol={" > "," < ", " like "," = ", " != "};
        JComboBox<String> symbol = new JComboBox(tabSymbol);

        JTextField entry=new JTextField(20);

        JPanel[] where = new JPanel[demande.length];
        for (int i = 0; i<ligne.length;i++){
            where[i]=new JPanel();
            where[i].setLayout(new FlowLayout());
            where[i].setPreferredSize(new Dimension(1100,200));
            where[i].add(cond[i]);
        }
        where[0].add(symbol);
        where[0].add(entry);


        internForm.add(where[0],BorderLayout.SOUTH);





        table.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                for (int i = 0; i < ligne.length; i++){
                    if (i != table.getSelectedIndex()) {
                        internForm.remove(ligne[i]);
                        internForm.remove(where[i]);
                    }
                }
                where[table.getSelectedIndex()].add(symbol);
                where[table.getSelectedIndex()].add(entry);
                internForm.add(ligne[table.getSelectedIndex()],BorderLayout.CENTER);
                internForm.add(where[table.getSelectedIndex()],BorderLayout.SOUTH);
                internForm.revalidate();
            }
        });

        valider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String infSelect="SELECT ";
                String join=null;
                String condition;
                boolean codezero=false;
                boolean first = true;
                if (dataBase==null || dataBase.isConnect()==false){
                    reponsearea.append("Connecter vous d'abord a la base de donner !\n");
                }
                else{

                    for (int i =0; i < demande[table.getSelectedIndex()].length;i++){
                        if (demande[table.getSelectedIndex()][i].isSelected()){
                            if (first == false) infSelect += ", ";

                            first=false;
                            if (table.getSelectedIndex() == 0 && i == 0){
                                infSelect+="t3.nom AS nom_abonnement, prix AS prix_abonnement, date_paiement, nb_point, debut_abonnement, fin_abonnement";
                                join = " t1 INNER JOIN abonnement_test t2 ON t1.id_membre = t2.id_membre " +
                                        "INNER JOIN type_abonnement t3 ON t2.type_abonnement = t3.id";
                                codezero=true;
                            }
                            else if (table.getSelectedIndex() == 0 && i == 1 && codezero==true){
                                infSelect+= "t1.nom AS nom_membre";

                            }
                            else if (table.getSelectedIndex() == 1 && i == 0){
                                infSelect+=demande[table.getSelectedIndex()][i].getText();
                                join = " t1 INNER JOIN role t2 ON t1.id_role = t2.id_role";
                            }

                            else if (table.getSelectedIndex() == 2 && i == 0){
                                infSelect+=demande[table.getSelectedIndex()][i].getText();
                                join = " t1 INNER JOIN role_intervenant t3 ON t1.id = t3.id_intervenant " +
                                        "INNER JOIN role t2 ON t2.id_role = t3.id_role";

                            }
                            else if (table.getSelectedIndex() == 2 && i == 1){
                                infSelect+="birthdate";
                            }
                            else if (table.getSelectedIndex() == 3 && i == 0){
                                infSelect+="t2.nom";
                                join=" t1 INNER JOIN membre t2 ON t1.id_membre=t2.id_membre";
                            }
                            else if (table.getSelectedIndex() == 3 && i == 1){
                                infSelect+="t3.nom";
                                if (join!=null){
                                    join+=" INNER JOIN intervenant t3 ON t1.id_intervenant_demande=t3.id";
                                }
                                else{
                                    join=" t1 INNER JOIN intervenant t3 ON t1.id_intervenant_demande=t3.id";
                                }
                            }
                            else if (table.getSelectedIndex() == 3 && i == 2){
                                infSelect+="nom_service";
                                if (join!=null){
                                    join+=" INNER JOIN services t4 ON t1.id_service_membre=t4.id_services";
                                }
                                else{
                                    join=" t1 INNER JOIN intervenant t4 ON t1.id_service_membre=t4.id_services";
                                }
                            }
                            else if (table.getSelectedIndex() == 4 && i == 0){
                                infSelect+=demande[table.getSelectedIndex()][i].getText();
                                join = " t1 INNER JOIN type_abonnement t2 ON t1.type_abonnement = t2.id";
                            }
                            else if (table.getSelectedIndex() == 4 && i == 1){
                                infSelect+=demande[table.getSelectedIndex()][i].getText();
                                if (join==null){
                                    join = " t1 INNER JOIN type_abonnement t2 ON t1.type_abonnement = t2.id";
                                }
                            }
                            else if (table.getSelectedIndex() == 4 && i == 2){
                                infSelect+="description1, description2, description3";
                            }
                            else{
                                infSelect+=demande[table.getSelectedIndex()][i].getText();
                            }

                        }
                    }

                    if (table.getSelectedIndex()==4){
                        infSelect+=" From info_abonnement";
                    }
                    else{
                        infSelect+=" FROM "+table.getSelectedItem().toString();
                    }




                    if (cond[table.getSelectedIndex()].getSelectedIndex()!=0){

                        if (table.getSelectedIndex()==2 && cond[table.getSelectedIndex()].getSelectedIndex()==1){
                            condition=" WHERE birthdate"+symbol.getSelectedItem().toString()+"?";
                        }
                        else if (table.getSelectedIndex()==3 && cond[table.getSelectedIndex()].getSelectedIndex()==1){
                            condition=" WHERE t2.nom"+symbol.getSelectedItem().toString()+"?";
                            if (join==null){
                                join=" t1 INNER JOIN membre t2 ON t1.id_membre=t2.id_membre";
                            }
                        }
                        else
                        {
                            condition=" WHERE "+cond[table.getSelectedIndex()].getSelectedItem().toString()+symbol.getSelectedItem().toString()+" ?";
                        }

                        if (join!=null){infSelect += join;}
                        infSelect+=condition;
                        reponsearea.setText("Resulta de la Requete : "+infSelect+"\n? ="+entry.getText()+"\n");
                        reponsearea.append(dataBase.selectAll(infSelect,new String[]{entry.getText()}));

                    }
                    else {
                        if (join!=null){infSelect += join;}

                        reponsearea.setText("Resulta de la Requete : "+infSelect+"\n");
                        reponsearea.append(dataBase.selectAll(infSelect,null));
                    }


                }
            }
        });
    }

    private String modifJoin(String join,String table,String cle2,String cleEtranger){

        if (join!=null){
            join+=table;
        }
        else{
            join = " t1 CROSS JOIN "+table+" t2 ON t1."+cleEtranger+"= t2."+cle2;
        }
        return join;
    }

    private JPanel bddConnect (){
        JPanel bddConnectPanel = new JPanel();
        bddConnectPanel.setPreferredSize(new Dimension(getWidth(),45));

        JPanel bddp = new JPanel();
        bddConnectPanel.add(bddp);

        JTextField bddName = new JTextField(10);
        JLabel lbddName = new JLabel("Nom BDD: ");
        bddp.add(lbddName);
        bddp.add(bddName);

        JPanel userp = new JPanel();
        bddConnectPanel.add(userp);

        JTextField user = new JTextField(10);
        JLabel luser = new JLabel("User: ");

        userp.add(luser);
        userp.add(user);


        JPanel passwordp = new JPanel();
        bddConnectPanel.add(passwordp);

        JPasswordField password = new JPasswordField(10);
        JLabel lpassword = new JLabel("Mdp: ");

        passwordp.add(lpassword);
        passwordp.add(password);


        JPanel serverNamep = new JPanel();
        bddConnectPanel.add(serverNamep);

        JTextField serverName = new JTextField(10);
        JLabel lserverName = new JLabel("Addresse du server: ");

        serverNamep.add(lserverName);
        serverNamep.add(serverName);


        JPanel portp = new JPanel();
        bddConnectPanel.add(portp);

        JTextField port = new JTextField(10);
        JLabel lport = new JLabel("¨Port :");

        portp.add(lport);
        portp.add(port);



        JButton testConnect = new JButton("Test Connection");
        JLabel connect = new JLabel("");

        bddConnectPanel.add(testConnect);
        bddConnectPanel.add(connect);

        //Parametre par defaut
        bddName.setText("technicall");
        user.setText("root");
        password.setText("");
        serverName.setText("localhost");
        port.setText("3306");










        testConnect.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                char [] bpass = password.getPassword();
                String pass="";
                for (int i = 0 ; i<bpass.length;i++){
                    pass+=bpass[i];
                }

                dataBase = new DataBase(bddName.getText(),user.getText(),pass,Integer.parseInt(port.getText()),serverName.getText());
                if (dataBase.isConnect()) {
                    connect.setText("Connection Reussi !");
                }
                else{
                    connect.setText("Connection impossible !");
                }

            }

        });

        return bddConnectPanel;
    }

}
