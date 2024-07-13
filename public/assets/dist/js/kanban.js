//variables
//alert('banban loaded');
let cardBeingDragged;
let cardClassBeingDragged;

let dropzones = document.querySelectorAll('.dropzone');
let priorities;
// let cards = document.querySelectorAll('.kanbanCard');
let dataColors = [
    {color:"yellow", title:"backlog"},
    {color:"green",  title:"to do"},
    {color:"blue",   title:"in progress"},
    {color:"purple", title:"testing"},
    {color:"red",    title:"done"}
];

let colorClass = [
    {class:"warning", color:"yellow"},
    {class:"success", color:"green"},
    {class:"info",    color:"blue"},
    {class:"primary", color:"purple"},
    {class:"danger",  color:"red"}
];

let dataCards = {
    config:{
        maxid:0
    },
    cards:[]
};
  
let theme="light";
//get current cards
let kanBoards = JSON.parse(dataKboards);
let kanCards =  JSON.parse(dataKcards);

$(document).ready(()=>{
    $("#loadingScreen").addClass("d-none");
    theme = localStorage.getItem('@kanban:theme');
    
    if(theme){
        $("body").addClass(`${theme==="light"?"":"darkmode"}`);
    }
    
    localStorage.clear();
    initializeBoards();
    
    if(JSON.parse(localStorage.getItem('@kanban:data'))){
        dataCards = JSON.parse(localStorage.getItem('@kanban:data'));
        initializeComponents(dataCards);
    }
    
    setCurrentCards();
    initializeCards();
    
    $('#add').click(()=>{
        const title = $('#titleInput').val()!==''?$('#titleInput').val():null;
        const description = $('#descriptionInput').val()!==''?$('#descriptionInput').val():null;
        $('#titleInput').val('');
        $('#descriptionInput').val('');
        if(title && description){
            let id = dataCards.config.maxid+1;
            const newCard = {
                id,
                title,
                description,
                position:"yellow",
                priority: false
            }
            dataCards.cards.push(newCard);
            dataCards.config.maxid = id;
            save();
            appendComponents(newCard);
            initializeCards();
        }
    });
    
    $("#deleteAll").click(()=>{
        dataCards.cards = [];
        save();
    });
    
    $("#theme-btn").click((e)=>{
        e.preventDefault();
        $("body").toggleClass("darkmode");
        if(theme){
            localStorage.setItem("@kanban:theme", `${theme==="light"?"darkmode":""}`)
        }
        else{
            localStorage.setItem("@kanban:theme", "darkmode")
        }
    });
});


//functions
function initializeBoards(){    
    /*
    dataColors.forEach(item=>{
        let htmlString = `
        <div class="board">
            <h3 class="text-center">${item.title.toUpperCase()}</h3>
            <div class="dropzone" id="${item.color}">
                
            </div>
        </div>
        `
        $("#boardsContainer").append(htmlString)
    });
    */
    
    let dropzones = document.querySelectorAll('.dropzone');
    dropzones.forEach(dropzone=>{
        dropzone.addEventListener('dragenter', dragenter);
        dropzone.addEventListener('dragover', dragover);
        dropzone.addEventListener('dragleave', dragleave);
        dropzone.addEventListener('drop', drop);
    });
}

function setCurrentCards(){
  //now put info in the cards
  for (var item of kanCards) 
  {
    let id = item.kbocard_id;
    let title = item.item_name;
    let description = item.item_desc;
    let position = item.color;
    
    const currentCard = {
                  id,
                  title,
                  description,
                  position,
                  priority: false
                }
              
    dataCards.cards.push(currentCard);
    dataCards.config.maxid = id;
    //alert(id);
    appendComponents(currentCard);
    initializeCards();
  } 
}

function initializeCards(){
    cards = document.querySelectorAll('.kanbanCard');
    cards.forEach(card=>{
        card.addEventListener('dragstart', dragstart);
        card.addEventListener('drag', drag);
        card.addEventListener('dragend', dragend);
    });
}

function initializeComponents(dataArray){
    //create all the stored cards and put inside of the todo area
    dataArray.cards.forEach(card=>{
        appendComponents(card); 
    })
}

function appendComponents(card){
    //creates new card inside of the todo area      
    for(var item of colorClass){
      var clas  = item.color;
      var clas2 = item.class;
      if(card.position === item.color){
        var cardStr = 'alert-'+item.class;
      }
    }
    //alert(cardStr);
    
    let htmlString = 
        `
          <div id=${card.id.toString()} class="kanbanCard ${card.position} alert ${cardStr}" draggable="true">
            ${card.description}
          </div>
        `
    $(`#${card.position}`).append(htmlString);
    priorities = document.querySelectorAll(".priority");
}

function togglePriority(event){
    event.target.classList.toggle("is-priority");
    dataCards.cards.forEach(card=>{
        if(event.target.id.split('-')[1] === card.id.toString()){
            card.priority=card.priority?false:true;
        }
    })
    save();
}

function deleteCard(id){
  alert('You are about to delete card id ' + id);
    dataCards.cards.forEach(card=>{
        if(card.id === id){
            let index = dataCards.cards.indexOf(card);
            console.log(index)
            dataCards.cards.splice(index, 1);
            console.log(dataCards.cards);
            save();
        }
    })
}

function removeCardClasses(cardClassBeingDragged, cardStr){
    cardClassBeingDragged.classList.remove('alert-danger');
    cardClassBeingDragged.classList.remove('alert-info');
    cardClassBeingDragged.classList.remove('alert-primary');
    cardClassBeingDragged.classList.remove('alert-success');
    cardClassBeingDragged.classList.remove('alert-warning');    
    cardClassBeingDragged.classList.add(cardStr);
}

function removeClasses(cardBeingDragged, color){
    cardBeingDragged.classList.remove('red');
    cardBeingDragged.classList.remove('blue');
    cardBeingDragged.classList.remove('purple');
    cardBeingDragged.classList.remove('green');
    cardBeingDragged.classList.remove('yellow');
    cardBeingDragged.classList.add(color);
    position(cardBeingDragged, color);
}

function save(){
    localStorage.setItem('@kanban:data', JSON.stringify(dataCards));
}

function position(cardBeingDragged, color){
    const index = dataCards.cards.findIndex(card => card.id === parseInt(cardBeingDragged.id));
    dataCards.cards[index].position = color;
    save();
}

//cards
function dragstart(){
    dropzones.forEach( dropzone=>dropzone.classList.add('highlight'));
    this.classList.add('is-dragging');
}

function drag(){
    
}

function dragend(){
    dropzones.forEach( dropzone=>dropzone.classList.remove('highlight'));
    this.classList.remove('is-dragging');
}

// Release cards area
function dragenter(){

}

function dragover({target}){
    this.classList.add('over');
    cardBeingDragged = document.querySelector('.is-dragging');
    if(this.id ==="yellow"){
        removeClasses(cardBeingDragged, "yellow"); 
    }
    else if(this.id ==="green"){
        removeClasses(cardBeingDragged, "green");
    }
    else if(this.id ==="blue"){
        removeClasses(cardBeingDragged, "blue");
    }
    else if(this.id ==="purple"){
        removeClasses(cardBeingDragged, "purple");
    }
    else if(this.id ==="red"){
        removeClasses(cardBeingDragged, "red");
    }
    this.appendChild(cardBeingDragged);
    
    //
    cardClassBeingDragged = document.querySelector('.is-dragging');
    
    if(this.id ==="yellow"){
        removeCardClasses(cardClassBeingDragged, "alert-warning"); 
    }
    else if(this.id ==="green"){
        removeCardClasses(cardClassBeingDragged, "alert-success");
    }
    else if(this.id ==="blue"){
        removeCardClasses(cardClassBeingDragged, "alert-info");
    }
    else if(this.id ==="purple"){
        removeCardClasses(cardClassBeingDragged, "alert-primary");
    }
    else if(this.id ==="red"){
        removeCardClasses(cardClassBeingDragged, "alert-danger");
    }   
    this.appendChild(cardClassBeingDragged);
   
}

function dragleave(){
  
    this.classList.remove('over');
}

function drop(){
    this.classList.remove('over');
}