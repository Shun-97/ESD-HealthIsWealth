// use the website to confirm what query to send
function action_to_table(pquery) {
   fetch('https://esd-healthiswell-69.hasura.app/v1/graphql', {
      method: 'POST',
      headers: {
         'Content-Type': 'application/json',
         'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
      },
      body: JSON.stringify({
         query: pquery
      })
   })
      .then((res) => res.json())
      .then((result) => console.log(result));
}