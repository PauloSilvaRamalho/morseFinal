// C++ code
//
int botao1= 13;
int botao2 = 12;

bool botaoPressionado1 = false;
unsigned long tempStr1 = 0;
unsigned long tempStr3 = 0;
unsigned long tempPress1 = 0;
unsigned long tempStr2 = 0;
unsigned long tempPress2 = 0;
bool botaoPressionado2 = false;  


void setup()
{
  Serial.begin(9600);
  pinMode (botao1, INPUT_PULLUP);
  pinMode (botao2, INPUT_PULLUP);
}

void loop()
{
  int estadoBot1 = digitalRead(botao1);
  
  if (estadoBot1 == HIGH && !botaoPressionado1) {
    tempStr1 = millis(); 
    botaoPressionado1 = true;
  }
  
  if (estadoBot1 == LOW && botaoPressionado1 && !botaoPressionado2) {
    tempPress1 = millis() - tempStr1; 
    botaoPressionado1 = false;
    
    if (tempPress1 < 350){
    	Serial.print(".");
    }else if (tempPress1 > 350){
    	Serial.print("-");
    }
  }  
 
  int estadoBot2 = digitalRead(botao2);
  if (estadoBot2 == HIGH && !botaoPressionado2) {
    tempStr2 = millis(); 
    botaoPressionado2 = true;
  }
  
  if (estadoBot2 == LOW && botaoPressionado2 && !botaoPressionado1) {
    tempPress2 = millis() - tempStr2; 
    botaoPressionado2 = false;
    
    if (tempPress2 < 350){
    	Serial.print(" ");
    }else if (tempPress2 > 350 && tempPress2){
    	Serial.print("/");
    }
  }
  if (estadoBot1 == LOW && estadoBot2 == LOW && botaoPressionado1 && botaoPressionado2){
      Serial.print("|");
      botaoPressionado2 = false;
      botaoPressionado1 = false;
  } 
}