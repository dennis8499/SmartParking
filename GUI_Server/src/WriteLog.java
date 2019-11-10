import java.io.FileWriter;
import java.io.IOException;

public class WriteLog {
	private FileWriter fw;

	public void StartLog(String text) {
		try {
			String textName = setDate() + " Server.txt";
			fw = new FileWriter(textName, true);
			Write(setTime() + ":" + text);
			Flush();
			Close();
		} catch (IOException e) {
			e.printStackTrace();
		}

	}

	private void Write(String text) throws IOException {
		fw.write(text + "\r\n");
	}

	private void Flush() throws IOException {
		fw.flush();
	}

	private void Close() throws IOException {
		fw.close();
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

}
