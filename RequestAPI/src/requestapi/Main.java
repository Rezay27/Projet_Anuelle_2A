package requestapi;

import java.sql.*;

public class Main {
    public static void main(String[ ] args) {

        Connection connection = null;
        ResultSet result = null;
        Statement sender = null;
        String request = "SELECT * FROM demandes";
        ResultSetMetaData rsmd = null;

        //Chargement des pilote
        try {
            Class.forName("com.mysql.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }

        try {
            connection = DriverManager.getConnection("jdbc:mysql://localhost/technicall", "root", "");
        } catch (SQLException e) {
            e.printStackTrace();
        }


        try {
            sender = connection.createStatement();
        } catch (SQLException e) {
            e.printStackTrace();
        }

        try {
            result = sender.executeQuery(request);
            rsmd = result.getMetaData();

        int nbCols = rsmd.getColumnCount();
        while (result.next()) {
            for (int i = 1; i <= nbCols; i++)
                System.out.print(result.getString(i) + " ");
            System.out.println();
        }
        result.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}

