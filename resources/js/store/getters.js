export const tournamentGetters = {
    addOrderToParticipants: (state, getters) => {
        return state.tournament.participants.map((p, i) => {
            return {
                id: i,
                name: p.name,
                image_url: p.image ? p.image.image_url : null,
                order: i
            };
        });
    },
    orderParticipantByTeam: (state,getters)=>{
        let array=[]
        // for (let i = 0; i < state.tournament.participants.length; i++) {
        //     if(i%2 ==0){
        //         array.push(sate.tournamen)
        //     }
            
        // }
        array = state.tournaments.participants.forEach((element,i,arr) => {
            if(i%2 ==0){
                array.push(arr[i-1],element)
            }
            
        });
        return array
    }
};
