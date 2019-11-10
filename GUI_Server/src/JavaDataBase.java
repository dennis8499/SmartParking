import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Stack;

import com.mysql.jdbc.DatabaseMetaData;

public class JavaDataBase {
	private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
	private static final String DB_URL = "jdbc:mysql://localhost:3306/smartparking?useUnicode=true&characterEncoding=Big5";
	private static final String USER = "test";
	private static final String PASS = "test";

	private String updateSQL;
	private String insertSQL;
	private String selectSQL;
	private String createSQL;

	private String Exits = "#0";
	private String Enter = "#1";
	private String GetCar = "#2";
	private String NoCar = "#3";

	private Statement stat = null;
	private ResultSet rs = null;
	private Connection con = null;
	private PreparedStatement pst = null;
	private DatabaseMetaData md = null;

	private enum carstatetype {
		IN, OUT, Y, N;
	}

	public void SelectSQL(String Type, String ParkingID, String ParkingDB) {
		try {
			String IN = carstatetype.IN.toString();
			String OUT = carstatetype.OUT.toString();
			String log = "SelectSQL Connecting to Database...";
			Class.forName(JDBC_DRIVER);
			WriteLog writelog = new WriteLog();
			System.out.println(log);
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			String query = "SELECT * FROM $TableName WHERE type = ?";
			selectSQL = query.replace("$TableName", ParkingDB + "log");
			PreparedStatement stmt = con.prepareStatement(selectSQL);
			stmt.setString(1, IN);
			rs = stmt.executeQuery();			
			System.out.println(ParkingDB + "log");
			rs.last();
			int countIN = rs.getRow();
			System.out.println(countIN);
			query = "SELECT * FROM $TableName WHERE type = ?";
			selectSQL = query.replace("$TableName", ParkingDB + "log");
			PreparedStatement stnt = con.prepareStatement(selectSQL);
			stnt.setString(1, OUT);
			ResultSet result = stnt.executeQuery();			
			result.last();
			int countOUT = result.getRow();
			System.out.println(countOUT);
			int sum = countIN - countOUT;			
			System.out.println(sum);
			if (sum > 0) {
				InsertSQL(Type, ParkingID, ParkingDB);
			}
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("Exception :" + x.toString());
		}
	}

	public void InsertSQL(String Type, String ParkingID, String ParkingDB) {
		try {
			String text = null;
			if (Type.equals(Exits)) {
				text = carstatetype.OUT.toString();
			} else if (Type.equals(Enter)) {
				text = carstatetype.IN.toString();
			}
			Class.forName(JDBC_DRIVER);
			String log = "InsertSQL Connecting to database...";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			String query = "INSERT INTO $TableName (parkingid, date, time, type) VALUES(?, ?, ?, ?)";
			insertSQL = query.replace("$TableName", ParkingDB + "log");
			PreparedStatement stmt = con.prepareStatement(insertSQL);
			stmt.setString(1, ParkingID);
			stmt.setString(2, setDate());
			stmt.setString(3, setTime());
			stmt.setString(4, text);
			stmt.execute();
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("Exception :" + x.toString());
		}

	}

	public void UpdateSQL(String Type, String ParkingID) {
		try {
			String text = null;
			if (Type.equals(GetCar)) {
				text = carstatetype.Y.toString();
			} else if (Type.equals(NoCar)) {
				text = carstatetype.N.toString();
			}
			Class.forName(JDBC_DRIVER);
			String log = "UpdateSQL Connecting to database...";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			updateSQL = "UPDATE parkingblock SET carstate = ? WHERE blockid = ?";
			PreparedStatement stmt = con.prepareStatement(updateSQL);
			stmt.setString(1, text);
			stmt.setString(2, ParkingID);
			stmt.executeUpdate();
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("Exception :" + x.toString());
		}
	}

	public void checkTable() {
		try {
			ArrayList<String> Name = new ArrayList<String>();
			Class.forName(JDBC_DRIVER);
			String log = "Start CheckTable";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			selectSQL = "SELECT * FROM parking WHERE type = ?";
			PreparedStatement stmt = con.prepareStatement(selectSQL);
			stmt.setString(1, "parking");
			rs = stmt.executeQuery();
			while (rs.next()) {
				Name.add(rs.getString("parkid"));
			}
			for (String data : Name) {
				String[] datas = data.split(",");
				for (String str : datas) {
					showTable(str);
				}
			}
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("SQLException :" + x.toString());
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	private void showTable(String ParkID) {
		int count = 0;
		String text = ParkID + "log";
		try {
			Class.forName(JDBC_DRIVER);
			String log = "Start showTable";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			md = (DatabaseMetaData) con.getMetaData();
			ResultSet result = md.getTables(null, null, "%", null);
			while (result.next()) {
				if (text.toLowerCase().equals(result.getString(3))) {
					count++;
				}
			}
			if (count == 0) {
				createTable(ParkID);
			} else if (count != 0) {
				count = 0;
			}
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("Exception :" + x.toString());
		}
	}

	private void createTable(String ParkingID) {
		try {
			Class.forName(JDBC_DRIVER);
			String log = "Start CreateTable";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			String query = "CREATE TABLE $TableName (seqno int(20) PRIMARY KEY AUTO_INCREMENT, parkingid varchar(30) NOT NULL, date date NOT NULL, time time(6) NOT NULL, type enum('IN','OUT') NOT NULL)";
			createSQL = query.replace("$TableName", ParkingID + "log");
			Statement stmt = con.createStatement();
			stmt.executeUpdate(createSQL);
			Close();
		} catch (SQLException x) {
			System.out.println("SQLException :" + x.toString());
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void UpdateNodemcu(String ParkingID, String States) {
		try {
			String text = null;
			if (States.equals("start")) {
				text = carstatetype.Y.toString();
			} else if (States.equals("offline")) {
				text = carstatetype.N.toString();
			}
			Class.forName(JDBC_DRIVER);
			String log = "UpdateNodemcu Connecting to database...";
			System.out.println(log);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(log);
			writelog = null;
			con = DriverManager.getConnection(DB_URL, USER, PASS);
			updateSQL = "UPDATE nodemcu SET valid = ? WHERE blockno = ?";
			PreparedStatement stmt = con.prepareStatement(updateSQL);
			stmt.setString(1, text);
			stmt.setString(2, ParkingID);
			stmt.executeUpdate();
			Close();
		} catch (ClassNotFoundException e) {
			System.out.println("DriverClassNotFound :" + e.toString());
		} catch (SQLException x) {
			System.out.println("Exception :" + x.toString());
		}

	}

	private String setDate() {
		java.util.Date javaDate = new java.util.Date();
		long javaTime = javaDate.getTime();
		java.sql.Date sqlDate = new java.sql.Date(javaTime);
		return sqlDate.toString();
	}

	private String setTime() {
		java.util.Date javaDate = new java.util.Date();
		long javaTime = javaDate.getTime();
		java.sql.Time sqlTime = new java.sql.Time(javaTime);
		return sqlTime.toString();
	}

	private void Close() {
		try {
			if (rs != null) {
				rs.close();
				rs = null;
			}
			if (stat != null) {
				stat.close();
				stat = null;
			}
			if (pst != null) {
				pst.close();
				pst = null;
			}
		} catch (SQLException e) {
			System.out.println("Close Exception :" + e.toString());
		}
	}
}
