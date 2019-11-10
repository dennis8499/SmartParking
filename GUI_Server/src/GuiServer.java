import java.util.Date;

import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken;
import org.eclipse.paho.client.mqttv3.MqttCallback;
import org.eclipse.paho.client.mqttv3.MqttClient;
import org.eclipse.paho.client.mqttv3.MqttException;
import org.eclipse.paho.client.mqttv3.MqttMessage;

import javafx.application.Application;
import javafx.application.Platform;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.control.TextArea;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.GridPane;
import javafx.stage.Stage;

public class GuiServer extends Application implements MqttCallback {
	TextArea taLog = new TextArea();
	Button startConnect = new Button();
	Button DisConnect = new Button();
	Label state = new Label();

	private MqttClient client;
	private String Exits = "#0";
	private String Enter = "#1";
	private String GetCar = "#2";
	private String NoCar = "#3";
	private boolean State = false;

	private String States = null, ParkingID = null, ParkingDB = null, ParkingState = null;

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		JavaDataBase jdbc = new JavaDataBase();
		jdbc.checkTable();
		jdbc = null;
		launch(args);
	}

	@Override
	public void start(Stage stage) throws Exception {
		// TODO Auto-generated method stub

		ScrollPane scrollpane = new ScrollPane(taLog);
		BorderPane borderpane = new BorderPane();
		GridPane gridpane = new GridPane();

		gridpane.add(startConnect, 0, 0);
		gridpane.add(DisConnect, 1, 0);
		gridpane.add(state, 2, 0);

		startConnect.setText("Start Connect");
		DisConnect.setText("DisConnect");

		borderpane.setCenter(scrollpane);
		borderpane.setBottom(gridpane);

		startConnect.setOnAction(event -> {
			if(!State){
				connect();
				Platform.runLater(() -> taLog.appendText(new Date() + ":建立連線\n"));				
				state.setText("建立連線");
				State = true;
			}else{				
				Platform.runLater(() -> taLog.appendText(new Date() + ":已經連線\n"));
			}
			
		});

		DisConnect.setOnAction(event -> {
			Disconnect();
		});

		Scene scene = new Scene(borderpane);
		stage.setScene(scene);
		stage.setTitle("MqttServer");
		stage.show();

	}

	public void connect() {
		try {
			client = new MqttClient("tcp://iot.eclipse.org:1883", "Server");
			client.connect();
			client.setCallback(this);
			client.subscribe("SmartParking/#");
			String text = "Server start";
			MqttMessage message = new MqttMessage();
			message.setQos(2);
			message.setPayload(text.getBytes());
			client.publish("SmartParking", message);
			WriteLog writelog = new WriteLog();
			writelog.StartLog(text);
			writelog = null;
		} catch (MqttException e) {
			e.printStackTrace();
		}
	}

	public void Disconnect() {
		try {
			if (client.isConnected()) {
				client.disconnect();
				client.close();
				Platform.runLater(() -> taLog.appendText(new Date() + ":中斷連線\n"));
				state.setText("中斷連線");
				State = false;
			} else if (!client.isConnected()) {
				Platform.runLater(() -> taLog.appendText(new Date() + ":尚未連線\n"));
				System.out.println("尚未連線");
			}

		} catch (MqttException e) {
			e.printStackTrace();
		}
	}

	@Override
	public void connectionLost(Throwable arg0) {
		// TODO Auto-generated method stub
		String text = "Disconnect to broke";
		System.out.println(text);
		WriteLog writelog = new WriteLog();
		writelog.StartLog(text);
		Platform.runLater(() -> taLog.appendText(new Date() + ":Disconnect to broke\n"));
		do {
			try {
				text = "ReConnecting";
				System.out.println(text);
				writelog.StartLog(text);
				Platform.runLater(() -> taLog.appendText(new Date() + ":ReConnecting\n"));
				connect();
			} catch (Exception e) {
				e.printStackTrace();
			}
		} while (!client.isConnected());
		text = "Successfully ReConnected";
		System.out.println(text);
		writelog.StartLog(text);
		Platform.runLater(() -> taLog.appendText(new Date() + ":Successfully ReConnected\n"));
		writelog = null;

	}

	@Override
	public void deliveryComplete(IMqttDeliveryToken arg0) {
		// TODO Auto-generated method stub

	}

	@Override
	public void messageArrived(String topic, MqttMessage message) throws Exception {
		// TODO Auto-generated method stub
		System.out.println(topic);
		System.out.println(message);
		String device_message = new String(message.getPayload());
		WriteLog writelog = new WriteLog();
		writelog.StartLog(device_message);
		writelog = null;
		if (topic.equals("SmartParking/SensorState")) {
			ParkingID = device_message.substring(0, 6);
			ParkingState = device_message.substring(6);
			if (ParkingState.equals("offline")) {
				Platform.runLater(
						() -> taLog.appendText(new Date() + ":停車格: " + ParkingID + " 感測器狀態: " + ParkingState + "\n"));
				JavaDataBase jdbc = new JavaDataBase();
				jdbc.UpdateNodemcu(ParkingID, ParkingState);
				jdbc = null;
			} else if (ParkingState.equals("start")) {
				Platform.runLater(
						() -> taLog.appendText(new Date() + ":停車格: " + ParkingID + " 感測器狀態: " + ParkingState + "\n"));
				JavaDataBase jdbc = new JavaDataBase();
				jdbc.UpdateNodemcu(ParkingID, ParkingState);
				jdbc = null;
			}
		}

		States = device_message.substring(0, 2);
		if (States.equals(Enter)) {
			ParkingID = device_message.substring(2);
			ParkingDB = device_message.substring(2, 5);
		} else if (States.equals(Exits)) {
			ParkingID = device_message.substring(2);
			ParkingDB = device_message.substring(2, 5);
		} else if (States.equals(GetCar)) {
			ParkingID = device_message.substring(2);
			ParkingDB = device_message.substring(2, 5);
		} else if (States.equals(NoCar)) {
			ParkingID = device_message.substring(2);
			ParkingDB = device_message.substring(2, 5);
		}

		if (States.equals(Enter)) {
			Platform.runLater(() -> taLog.appendText(new Date() + ":停車場: " + ParkingDB + " 有車子進來\n"));
			JavaDataBase jdbc = new JavaDataBase();
			jdbc.InsertSQL(States, ParkingID, ParkingDB);
			jdbc = null;
		}
		if (States.equals(Exits)) {
			Platform.runLater(() -> taLog.appendText(new Date() + ":停車場: " + ParkingDB + " 有車子離開\n"));
			JavaDataBase jdbc = new JavaDataBase();
			jdbc.SelectSQL(States, ParkingID, ParkingDB);
			jdbc = null;
		}
		if (States.equals(GetCar)) {
			Platform.runLater(
					() -> taLog.appendText(new Date() + ":停車場: " + ParkingDB + " 停車格: " + ParkingID + "偵測到車\n"));
			JavaDataBase jdbc = new JavaDataBase();
			jdbc.UpdateSQL(States, ParkingID);
			jdbc = null;
		}
		if (States.equals(NoCar)) {
			Platform.runLater(
					() -> taLog.appendText(new Date() + ":停車場: " + ParkingDB + " 停車格: " + ParkingID + "車子離開\n"));
			JavaDataBase jdbc = new JavaDataBase();
			jdbc.UpdateSQL(States, ParkingID);
			jdbc = null;
		}

	}

}
