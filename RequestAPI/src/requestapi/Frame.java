package requestapi;

import javax.swing.*;

public class Frame extends JFrame {

    private static final long serialVersionUID = 1L;

    public Frame (String title){
        setTitle(title);
        setSize(1280,720);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setResizable(false);
        setLocationRelativeTo(null); //affiche la fenetre au millieu de l'ecran
        setVisible(true);


        this.add(new Panel());

    }


}
