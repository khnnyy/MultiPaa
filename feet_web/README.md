# feet_web

#include <WiFi.h>
#include <WebServer.h>

// Replace with your network credentials
const char* ssid = "ADZU-RIGHT";
const char* password = ""; // Ensure you have the password filled in if required

// Variables to store generated values
float mockTemperature;
int mockHeartRate;
int mockBloodSaturation;
float mockBodyWeight;
int mockGSR;
String mockFoot;

// Create a web server object that listens on port 80
WebServer server(80);

void setup() {
  Serial.begin(9600);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  Serial.println("Connecting...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // Define the endpoint to trigger data generation and return values
  server.on("/get_data", HTTP_POST, handlePostRequest);

  // Start the server
  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  // Handle client requests
  server.handleClient();
}

// Function to handle POST requests
void handlePostRequest() {
  Serial.println("POST request received");
  generateValues(); // Generate new values on each request

  // Create a JSON response
  String response = "{";
  response += "\"temperature\": " + String(mockTemperature) + ",";
  response += "\"heartRate\": " + String(mockHeartRate) + ",";
  response += "\"bloodSaturation\": " + String(mockBloodSaturation) + ",";
  response += "\"bodyWeight\": " + String(mockBodyWeight) + ",";
  response += "\"gsr\": " + String(mockGSR) + ",";
  response += "\"foot\": \"" + mockFoot + "\"";
  response += "}";

  // Send the JSON response
  server.send(200, "application/json", response);
}

// Function to generate mock values
void generateValues() {
  // Generate random mock values
  mockTemperature = 20.0 + random(0, 100) / 10.0;      // Temperature between 20-30°C
  mockHeartRate = random(60, 100);                     // Heart rate between 60-100 bpm
  mockBloodSaturation = random(90, 100);               // Blood saturation between 90-100%
  mockBodyWeight = 60.0 + random(0, 500) / 10.0;       // Weight between 60-110 kg
  mockGSR = random(200, 1000);                         // GSR between 200-1000
  mockFoot = (random(0, 2) == 0) ? "left" : "right";   // Randomly "left" or "right" foot

  // Print generated values to the Serial Monitor
  Serial.println("Generated mock values:");
  Serial.print("Temperature: "); Serial.println(mockTemperature);
  Serial.print("Heart Rate: "); Serial.println(mockHeartRate);
  Serial.print("Blood Saturation: "); Serial.println(mockBloodSaturation);
  Serial.print("Body Weight: "); Serial.println(mockBodyWeight);
  Serial.print("GSR: "); Serial.println(mockGSR);
  Serial.print("Foot: "); Serial.println(mockFoot);
}
