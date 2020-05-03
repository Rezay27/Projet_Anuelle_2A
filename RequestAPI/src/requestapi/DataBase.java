package requestapi;
import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;

import java.sql.*;

public class DataBase {
    private Connection connect;
    private boolean isConnect;

    public DataBase(String BddName,String user,String password,int port,String serverName) {

        MysqlDataSource dataSource = new MysqlDataSource();
        dataSource.setUser(user);
        dataSource.setPassword(password);
        dataSource.setServerName(serverName);
        dataSource.setPort(port);
        dataSource.setDatabaseName(BddName);

        try {
            connect = dataSource.getConnection();
            this.isConnect=true;
        } catch (SQLException e) {
           this.isConnect=false;
        }

    }

    public boolean isConnect() {
        return isConnect;
    }

    public String selectAll (String sql, String[] param ){
        ResultSet result = null;
        ResultSetMetaData rsmd = null;
        PreparedStatement request = null;
        String r="";
        int nbParam;

        if (param == null){
            nbParam = 0;
        }
        else{
            nbParam = param.length;
        }


        try {

            request = this.connect.prepareStatement(sql);

            for (int i = 1; i <= nbParam; i++){
                request.setString(i, param[i-1]);
            }
            result = request.executeQuery();
            rsmd = result.getMetaData();


            int nbCols = rsmd.getColumnCount();
            for(int i = 1;i<= nbCols;i++){
                r+=rsmd.getColumnName(i)+"  ||  ";
            }
            r+="\n";

            while (result.next()) {
                for (int i = 1; i <= nbCols; i++)
                    r+=result.getString(i)+" || ";
                r+="\n";
            }
            result.close();
        } catch (SQLException e) {
            r="Erreur dans la Requette: "+e.getErrorCode()+"\n"+e.getMessage();
        }
        finally {
            return r;
        }

    }

}
