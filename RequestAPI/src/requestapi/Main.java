package requestapi;

import java.sql.*;

public class Main {
    public static void main(String[ ] args) {

        //Chargement des pilote
        Class.forName("sun.jbdc.obdc.JbdcObdcDriver");

        Connection connection = DriverManager.getConnection("jbdc:mysql://localhost/technicall", "root", "");

        ResultSet result = null;
        String request = "SELECT * FROM demandes";

        Statement sender = connection.createStatement();

        result = sender.executeQuery(request);

        ResultSetMetaData rsmd = result.getMetaData();
        int nbCols = rsmd.getColumnCount();
        while (result.next()) {
            for (int i = 1; i <= nbCols; i++)
                System.out.print(result.getString(i) + " ");
            System.out.println();
        }
        result.close();
    }
}

